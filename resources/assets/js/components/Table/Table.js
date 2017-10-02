import utils from '../../utils';
import telescopeUtils from '../../telescope-utils';

const filterBySelection = (selections, config, item) => {
	if (!selections || !selections.length || !config.selection.enabled || !config.selection.filterSelections) {
		return true; // don't filter anything
	} else {
		return config.selection.isSelectedFn(item);
	}
}

const filterAndSortData = (data, sortState, config, selections) => {
	// Filter by selections
	data = data.filter(filterBySelection.bind(null, selections, config));

	// Apply column filters
	config.columns
		.filter(column => !!column.filterOptions)
		.forEach(column => {
			data = data.filter(column.filterOptions.config.filterFn.bind(null, column.filterOptions.config.values, column.dataKey))
		});

	// Sort the data
	return data.sort(utils.compare.bind(null, sortState.key, sortState.subKey, sortState.ascending));
};

const mergeConfigDefaults = config => {
	var selectionConfig = {
		enabled: false,
		highlightSelections: false,
		filterSelections: false,
		isSelectedFn: null,
		onSelect: null,
		onClearSelections: null
	};

	return {
		defaultSortKey: config.defaultSortKey || 'name',
		rowIsClickable: typeof config.onRowClick !== 'undefined',
		onRowClick: config.onRowClick || function () {},
		selection: Object.assign({}, selectionConfig, config.selection),
		columns: config.columns || []
	};
}

export default {
	props: {
		config: {
			type: Object
		},
		data: {
			type: Array,
			default: () => []
		},
		selections: {
			type: Array,
			default: () => []
		}
	},
	data: function () {
		let defaultSortKey = this.config.defaultSortKey || 'name';
		return {
			sortState: {
				key: defaultSortKey,
				subKey: 'focal_length', // sub-sort by this as a tie breaker in case the values for the primary key are the same
				ascending: true
			}
		}
	},
	methods: {
		sortData(sortKey) {
			this.sortState.ascending = (this.sortState.key == sortKey) ? !this.sortState.ascending : true;
			this.sortState.key = sortKey;
		},
		getColumnFilterComponent(column) {
			if (!!column.filterOptions) {
				return `table-column-${column.filterOptions.type}`;
			}
		},
		getColumnCount() {
			let columnCount = this.computedConfig.columns.length;
			return this.computedConfig.selection.enabled ? columnCount + 1 : columnCount;
		},
		getRowClass(row) {
			return {
				selected: this.computedConfig.selection.enabled && this.computedConfig.selection.isSelectedFn(row) && this.computedConfig.selection.highlightSelections,
				clickable: this.computedConfig.rowIsClickable
			};
		}
	},
	computed: {
		computedData: function () {
			return filterAndSortData(this.data, this.sortState, this.computedConfig, this.selections);
		},
		computedConfig: function () {
			return mergeConfigDefaults(this.config);
		}
	}
}