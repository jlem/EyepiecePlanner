import utils from "../utils";
describe('utils', function () {
	describe('findIndexByProperty', function () {
		beforeEach(function () {
			this.items = [ { id: 1 }, { id: 2 } ];
			this.item = { id: 2 };
		});

		it('should return the index number of the object using the given property', function () {
			expect(utils.findIndexByProperty('id', this.items, this.item)).toBe(1);
		});
	});

	describe('findIndexById', function () {
		beforeEach(function () {
			this.items = [ { id: 1 }, { id: 2 } ];
			this.item = { id: 1 };
		});

		it('should return the index number of the object using its ID', function () {
			expect(utils.findIndexById(this.items, this.item)).toBe(0);
		});
	});

	describe('isSelected', function () {
		describe('with selected item', function () {
			beforeEach(function () {
				this.selectedItems = [ { id: 1 }, { id: 2 } ];
				this.item = { id: 1 };
			});

			it('should return true', function () {
				expect(utils.isSelected(this.selectedItems, this.item)).toBe(true);
			});
		});

		describe('with un-selected item', function () {
			beforeEach(function () {
				this.selectedItems = [ { id: 1 }, { id: 2 } ];
				this.item = { id: 3 };
			});

			it('should return false', function () {
				expect(utils.isSelected(this.selectedItems, this.item)).toBe(false);
			});
		});
	});

	describe('addSelection', function () {
		beforeEach(function () {
			this.items = [];
			this.item = { id: 1 };
			this.expectedItems = [ { id: 1 } ];
			this.actualItems = utils.addSelection(this.items, this.item);
		});

		it('should append the given item to the items list', function () {
			expect(this.expectedItems).toEqual(this.actualItems);
		});
	});

	describe('removeSelectionById', function () {
		beforeEach(function () {
			this.items = [ { id: 1 }, { id: 2 } ];
			this.item = { id: 1 };
			this.expectedItems = [ { id: 2 } ];
			this.actualItems = utils.removeSelectionById(this.items, this.item);
		});

		it('should append the given item to the items list', function () {
			expect(this.expectedItems).toEqual(this.actualItems);
		});
	});
});