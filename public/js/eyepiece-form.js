/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.l = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };

/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
/******/ 	};

/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};

/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

eval("//import telescopeUtilities from \"./telescope-utils\";\n//import formatters from \"./formatters\";\n//import utils from \"./utils\";\n//\n//'use strict';\n//\n//const ELEMENT = '#comparison';\n//\n//// Search\n//const search = (eyepieces, query) => (!query) ? [] : eyepieces.filter(eyepiece => telescopeUtilities.getEyepieceDescription(eyepiece).toLowerCase().indexOf(query.toLowerCase()) > -1);\n//\n//// View Model\n//new Vue({\n//\tel: ELEMENT,\n//\tdata: {\n//\t\ttelescope: window.telescope,\n//\t\teyepieces: window.eyepieces,\n//\t\tselectedEyepieces: [],\n//\t\tsearchResults: [],\n//\t\tpupilReference: false,\n//\t\tquery: null\n//\t},\n//\tmethods: {\n//\t\tgetEyepieceDescription: telescopeUtilities.getEyepieceDescription,\n//\t\tisSelected: utils.isSelected,\n//\t\tselect: function (selectedEyepieces, eyepiece) {\n//\t\t\tthis.selectedEyepices = utils.isSelected(selectedEyepieces, eyepiece)\n//\t\t\t\t? utils.removeSelectionById(selectedEyepieces, eyepiece)\n//\t\t\t\t: utils.addSelection(selectedEyepieces, eyepiece);\n//\t\t},\n//\t\tclearSelection: function () {\n//\t\t\tthis.selectedEyepieces = [];\n//\t\t},\n//\t\tsearch: function (eyepieces, query) {\n//\t\t\tthis.searchResults = search(eyepieces, query);\n//\t\t},\n//\t\tclearSearch: function () {\n//\t\t\tthis.query = null;\n//\t\t\tthis.search(this.query);\n//\t\t},\n//\t\ttogglePupilReference: function () {\n//\t\t\tthis.pupilReference = !this.pupilReference;\n//\t\t}\n//\t},\n//\tfilters: formatters\n//});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2V5ZXBpZWNlLWZvcm0uanM/YjQ0NCJdLCJzb3VyY2VzQ29udGVudCI6WyIvL2ltcG9ydCB0ZWxlc2NvcGVVdGlsaXRpZXMgZnJvbSBcIi4vdGVsZXNjb3BlLXV0aWxzXCI7XG4vL2ltcG9ydCBmb3JtYXR0ZXJzIGZyb20gXCIuL2Zvcm1hdHRlcnNcIjtcbi8vaW1wb3J0IHV0aWxzIGZyb20gXCIuL3V0aWxzXCI7XG4vL1xuLy8ndXNlIHN0cmljdCc7XG4vL1xuLy9jb25zdCBFTEVNRU5UID0gJyNjb21wYXJpc29uJztcbi8vXG4vLy8vIFNlYXJjaFxuLy9jb25zdCBzZWFyY2ggPSAoZXllcGllY2VzLCBxdWVyeSkgPT4gKCFxdWVyeSkgPyBbXSA6IGV5ZXBpZWNlcy5maWx0ZXIoZXllcGllY2UgPT4gdGVsZXNjb3BlVXRpbGl0aWVzLmdldEV5ZXBpZWNlRGVzY3JpcHRpb24oZXllcGllY2UpLnRvTG93ZXJDYXNlKCkuaW5kZXhPZihxdWVyeS50b0xvd2VyQ2FzZSgpKSA+IC0xKTtcbi8vXG4vLy8vIFZpZXcgTW9kZWxcbi8vbmV3IFZ1ZSh7XG4vL1x0ZWw6IEVMRU1FTlQsXG4vL1x0ZGF0YToge1xuLy9cdFx0dGVsZXNjb3BlOiB3aW5kb3cudGVsZXNjb3BlLFxuLy9cdFx0ZXllcGllY2VzOiB3aW5kb3cuZXllcGllY2VzLFxuLy9cdFx0c2VsZWN0ZWRFeWVwaWVjZXM6IFtdLFxuLy9cdFx0c2VhcmNoUmVzdWx0czogW10sXG4vL1x0XHRwdXBpbFJlZmVyZW5jZTogZmFsc2UsXG4vL1x0XHRxdWVyeTogbnVsbFxuLy9cdH0sXG4vL1x0bWV0aG9kczoge1xuLy9cdFx0Z2V0RXllcGllY2VEZXNjcmlwdGlvbjogdGVsZXNjb3BlVXRpbGl0aWVzLmdldEV5ZXBpZWNlRGVzY3JpcHRpb24sXG4vL1x0XHRpc1NlbGVjdGVkOiB1dGlscy5pc1NlbGVjdGVkLFxuLy9cdFx0c2VsZWN0OiBmdW5jdGlvbiAoc2VsZWN0ZWRFeWVwaWVjZXMsIGV5ZXBpZWNlKSB7XG4vL1x0XHRcdHRoaXMuc2VsZWN0ZWRFeWVwaWNlcyA9IHV0aWxzLmlzU2VsZWN0ZWQoc2VsZWN0ZWRFeWVwaWVjZXMsIGV5ZXBpZWNlKVxuLy9cdFx0XHRcdD8gdXRpbHMucmVtb3ZlU2VsZWN0aW9uQnlJZChzZWxlY3RlZEV5ZXBpZWNlcywgZXllcGllY2UpXG4vL1x0XHRcdFx0OiB1dGlscy5hZGRTZWxlY3Rpb24oc2VsZWN0ZWRFeWVwaWVjZXMsIGV5ZXBpZWNlKTtcbi8vXHRcdH0sXG4vL1x0XHRjbGVhclNlbGVjdGlvbjogZnVuY3Rpb24gKCkge1xuLy9cdFx0XHR0aGlzLnNlbGVjdGVkRXllcGllY2VzID0gW107XG4vL1x0XHR9LFxuLy9cdFx0c2VhcmNoOiBmdW5jdGlvbiAoZXllcGllY2VzLCBxdWVyeSkge1xuLy9cdFx0XHR0aGlzLnNlYXJjaFJlc3VsdHMgPSBzZWFyY2goZXllcGllY2VzLCBxdWVyeSk7XG4vL1x0XHR9LFxuLy9cdFx0Y2xlYXJTZWFyY2g6IGZ1bmN0aW9uICgpIHtcbi8vXHRcdFx0dGhpcy5xdWVyeSA9IG51bGw7XG4vL1x0XHRcdHRoaXMuc2VhcmNoKHRoaXMucXVlcnkpO1xuLy9cdFx0fSxcbi8vXHRcdHRvZ2dsZVB1cGlsUmVmZXJlbmNlOiBmdW5jdGlvbiAoKSB7XG4vL1x0XHRcdHRoaXMucHVwaWxSZWZlcmVuY2UgPSAhdGhpcy5wdXBpbFJlZmVyZW5jZTtcbi8vXHRcdH1cbi8vXHR9LFxuLy9cdGZpbHRlcnM6IGZvcm1hdHRlcnNcbi8vfSk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9qcy9leWVwaWVjZS1mb3JtLmpzIl0sIm1hcHBpbmdzIjoiQUFBQTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OzsiLCJzb3VyY2VSb290IjoiIn0=");

/***/ }
/******/ ]);