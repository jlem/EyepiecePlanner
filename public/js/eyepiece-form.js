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

"use strict";
eval("'use strict';\n\nvar telescope = {\n\tfocal_length: 2000,\n\taperture: 400,\n\tmax_magnification: 50,\n\tmax_pupil: 7\n};\n\n// Formatters\nvar append = function (append, value) { return value ? value + append : null; };\nvar numberFormat = function (value, precision) { return parseFloat(value.toFixed(precision)); };\n\n// Search\nvar getEyepieceDescription = function (eyepiece) { return eyepiece.manufacturer_name + ' ' + eyepiece.product_name + ' ' + eyepiece.focal_length + 'mm '; };\nvar isSelected = function (selectedEyepiecesMap, eyepiece) { return selectedEyepiecesMap.indexOf(eyepiece.id) > -1; };\nvar search = function (eyepieces, query) { return (!query) ? [] : eyepieces.filter(function (eyepiece) { return getEyepieceDescription(eyepiece).toLowerCase().indexOf(query.toLowerCase()) > -1; }); };\n\n// Telescope calculations\nvar calculateMagnification = function (eyepiece, telescope) { return telescope.focal_length / eyepiece.focal_length; };\nvar calculateTrueFoV = function (eyepiece, telescope) { return eyepiece.apparent_field / calculateMagnification(eyepiece, telescope); };\nvar calculateExitPupil = function (eyepiece, telescope) { return telescope.aperture / calculateMagnification(eyepiece, telescope); };\nvar calculateMaxMagnification = function (telescope) { return telescope.aperture / 25.4 * telescope.max_magnification; };\nvar calculateLowestMagnification = function (telescope) { return telescope.aperture / telescope.max_pupil; };\nvar isMagnificationTooHigh = function (eyepiece, telescope) { return calculateMagnification(eyepiece, telescope) > calculateMaxMagnification(telescope); };\nvar isExitPupilTooLarge = function (eyepiece, telescope) { return calculateExitPupil(eyepiece, telescope) > telescope.max_pupil; };\n\n// View Model\nnew Vue({\n\tel: '#comparison',\n\tdata: {\n\t\teyepieces: window.eyepieces,\n\t\tselectedEyepieces: [],\n\t\tselectedEyepiecesMap: [],\n\t\ttelescope: telescope,\n\t\tsearchResults: [],\n\t\tpupilReference: false,\n\t\tquery: null\n\t},\n\tmethods: {\n\t\tcalculateMagnification: calculateMagnification,\n\t\tcalculateTrueFoV: calculateTrueFoV,\n\t\tcalculateExitPupil: calculateExitPupil,\n\t\tcalculateMaxMagnification: calculateMaxMagnification,\n\t\tcalculateLowestMagnification: calculateLowestMagnification,\n\t\tisMagnificationTooHigh: isMagnificationTooHigh,\n\t\tisExitPupilTooLarge: isExitPupilTooLarge,\n\t\tgetEyepieceDescription: getEyepieceDescription,\n\t\tisSelected: isSelected,\n\t\tselect: function (eyepiece, event) {\n\t\t\tisSelected(this.selectedEyepiecesMap, eyepiece)\n\t\t\t\t? this.removeSelection(eyepiece)\n\t\t\t\t: this.addSelection(eyepiece)\n\t\t},\n\t\taddSelection: function (eyepiece) {\n\t\t\tthis.selectedEyepieces.push(eyepiece);\n\t\t\tthis.selectedEyepiecesMap.push(eyepiece.id);\n\t\t},\n\t\tremoveSelection: function (eyepiece) {\n\t\t\tvar index = this.selectedEyepiecesMap.indexOf(eyepiece.id);\n\t\t\tthis.selectedEyepieces.splice(index, 1);\n\t\t\tthis.selectedEyepiecesMap.splice(index, 1);\n\t\t},\n\t\tclearSelection: function () {\n\t\t\tthis.selectedEyepieces = [];\n\t\t\tthis.selectedEyepiecesMap = [];\n\t\t},\n\t\tsearch: function (query) {\n\t\t\tthis.searchResults = search(this.eyepieces, query);\n\t\t},\n\t\tclearSearch: function () {\n\t\t\tthis.query = null;\n\t\t\tthis.search(this.query);\n\t\t},\n\t\ttogglePupilReference: function () {\n\t\t\tthis.pupilReference = !this.pupilReference;\n\t\t}\n\t},\n\tfilters: {\n\t\tappend: append,\n\t\tmm: append.bind(null, ' mm'),\n\t\tdeg: append.bind(null, '°'),\n\t\tmag: append.bind(null, 'x'),\n\t\tnumberFormat: numberFormat\n\t}\n});//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2V5ZXBpZWNlLWZvcm0uanM/YjQ0NCJdLCJzb3VyY2VzQ29udGVudCI6WyIndXNlIHN0cmljdCc7XG5cbmxldCB0ZWxlc2NvcGUgPSB7XG5cdGZvY2FsX2xlbmd0aDogMjAwMCxcblx0YXBlcnR1cmU6IDQwMCxcblx0bWF4X21hZ25pZmljYXRpb246IDUwLFxuXHRtYXhfcHVwaWw6IDdcbn07XG5cbi8vIEZvcm1hdHRlcnNcbmNvbnN0IGFwcGVuZCA9IChhcHBlbmQsIHZhbHVlKSA9PiB2YWx1ZSA/IHZhbHVlICsgYXBwZW5kIDogbnVsbDtcbmNvbnN0IG51bWJlckZvcm1hdCA9ICh2YWx1ZSwgcHJlY2lzaW9uKSA9PiBwYXJzZUZsb2F0KHZhbHVlLnRvRml4ZWQocHJlY2lzaW9uKSk7XG5cbi8vIFNlYXJjaFxuY29uc3QgZ2V0RXllcGllY2VEZXNjcmlwdGlvbiA9IGV5ZXBpZWNlID0+IGV5ZXBpZWNlLm1hbnVmYWN0dXJlcl9uYW1lICsgJyAnICsgZXllcGllY2UucHJvZHVjdF9uYW1lICsgJyAnICsgZXllcGllY2UuZm9jYWxfbGVuZ3RoICsgJ21tICc7XG5jb25zdCBpc1NlbGVjdGVkID0gKHNlbGVjdGVkRXllcGllY2VzTWFwLCBleWVwaWVjZSkgPT4gc2VsZWN0ZWRFeWVwaWVjZXNNYXAuaW5kZXhPZihleWVwaWVjZS5pZCkgPiAtMTtcbmNvbnN0IHNlYXJjaCA9IChleWVwaWVjZXMsIHF1ZXJ5KSA9PiAoIXF1ZXJ5KSA/IFtdIDogZXllcGllY2VzLmZpbHRlcihleWVwaWVjZSA9PiBnZXRFeWVwaWVjZURlc2NyaXB0aW9uKGV5ZXBpZWNlKS50b0xvd2VyQ2FzZSgpLmluZGV4T2YocXVlcnkudG9Mb3dlckNhc2UoKSkgPiAtMSk7XG5cbi8vIFRlbGVzY29wZSBjYWxjdWxhdGlvbnNcbmNvbnN0IGNhbGN1bGF0ZU1hZ25pZmljYXRpb24gPSAoZXllcGllY2UsIHRlbGVzY29wZSkgPT4gdGVsZXNjb3BlLmZvY2FsX2xlbmd0aCAvIGV5ZXBpZWNlLmZvY2FsX2xlbmd0aDtcbmNvbnN0IGNhbGN1bGF0ZVRydWVGb1YgPSAoZXllcGllY2UsIHRlbGVzY29wZSkgPT4gZXllcGllY2UuYXBwYXJlbnRfZmllbGQgLyBjYWxjdWxhdGVNYWduaWZpY2F0aW9uKGV5ZXBpZWNlLCB0ZWxlc2NvcGUpO1xuY29uc3QgY2FsY3VsYXRlRXhpdFB1cGlsID0gKGV5ZXBpZWNlLCB0ZWxlc2NvcGUpID0+IHRlbGVzY29wZS5hcGVydHVyZSAvIGNhbGN1bGF0ZU1hZ25pZmljYXRpb24oZXllcGllY2UsIHRlbGVzY29wZSk7XG5jb25zdCBjYWxjdWxhdGVNYXhNYWduaWZpY2F0aW9uID0gdGVsZXNjb3BlID0+IHRlbGVzY29wZS5hcGVydHVyZSAvIDI1LjQgKiB0ZWxlc2NvcGUubWF4X21hZ25pZmljYXRpb247XG5jb25zdCBjYWxjdWxhdGVMb3dlc3RNYWduaWZpY2F0aW9uID0gdGVsZXNjb3BlID0+IHRlbGVzY29wZS5hcGVydHVyZSAvIHRlbGVzY29wZS5tYXhfcHVwaWw7XG5jb25zdCBpc01hZ25pZmljYXRpb25Ub29IaWdoID0gKGV5ZXBpZWNlLCB0ZWxlc2NvcGUpID0+IGNhbGN1bGF0ZU1hZ25pZmljYXRpb24oZXllcGllY2UsIHRlbGVzY29wZSkgPiBjYWxjdWxhdGVNYXhNYWduaWZpY2F0aW9uKHRlbGVzY29wZSk7XG5jb25zdCBpc0V4aXRQdXBpbFRvb0xhcmdlID0gKGV5ZXBpZWNlLCB0ZWxlc2NvcGUpID0+IGNhbGN1bGF0ZUV4aXRQdXBpbChleWVwaWVjZSwgdGVsZXNjb3BlKSA+IHRlbGVzY29wZS5tYXhfcHVwaWw7XG5cbi8vIFZpZXcgTW9kZWxcbm5ldyBWdWUoe1xuXHRlbDogJyNjb21wYXJpc29uJyxcblx0ZGF0YToge1xuXHRcdGV5ZXBpZWNlczogd2luZG93LmV5ZXBpZWNlcyxcblx0XHRzZWxlY3RlZEV5ZXBpZWNlczogW10sXG5cdFx0c2VsZWN0ZWRFeWVwaWVjZXNNYXA6IFtdLFxuXHRcdHRlbGVzY29wZTogdGVsZXNjb3BlLFxuXHRcdHNlYXJjaFJlc3VsdHM6IFtdLFxuXHRcdHB1cGlsUmVmZXJlbmNlOiBmYWxzZSxcblx0XHRxdWVyeTogbnVsbFxuXHR9LFxuXHRtZXRob2RzOiB7XG5cdFx0Y2FsY3VsYXRlTWFnbmlmaWNhdGlvbixcblx0XHRjYWxjdWxhdGVUcnVlRm9WLFxuXHRcdGNhbGN1bGF0ZUV4aXRQdXBpbCxcblx0XHRjYWxjdWxhdGVNYXhNYWduaWZpY2F0aW9uLFxuXHRcdGNhbGN1bGF0ZUxvd2VzdE1hZ25pZmljYXRpb24sXG5cdFx0aXNNYWduaWZpY2F0aW9uVG9vSGlnaCxcblx0XHRpc0V4aXRQdXBpbFRvb0xhcmdlLFxuXHRcdGdldEV5ZXBpZWNlRGVzY3JpcHRpb24sXG5cdFx0aXNTZWxlY3RlZCxcblx0XHRzZWxlY3Q6IGZ1bmN0aW9uIChleWVwaWVjZSwgZXZlbnQpIHtcblx0XHRcdGlzU2VsZWN0ZWQodGhpcy5zZWxlY3RlZEV5ZXBpZWNlc01hcCwgZXllcGllY2UpXG5cdFx0XHRcdD8gdGhpcy5yZW1vdmVTZWxlY3Rpb24oZXllcGllY2UpXG5cdFx0XHRcdDogdGhpcy5hZGRTZWxlY3Rpb24oZXllcGllY2UpXG5cdFx0fSxcblx0XHRhZGRTZWxlY3Rpb246IGZ1bmN0aW9uIChleWVwaWVjZSkge1xuXHRcdFx0dGhpcy5zZWxlY3RlZEV5ZXBpZWNlcy5wdXNoKGV5ZXBpZWNlKTtcblx0XHRcdHRoaXMuc2VsZWN0ZWRFeWVwaWVjZXNNYXAucHVzaChleWVwaWVjZS5pZCk7XG5cdFx0fSxcblx0XHRyZW1vdmVTZWxlY3Rpb246IGZ1bmN0aW9uIChleWVwaWVjZSkge1xuXHRcdFx0dmFyIGluZGV4ID0gdGhpcy5zZWxlY3RlZEV5ZXBpZWNlc01hcC5pbmRleE9mKGV5ZXBpZWNlLmlkKTtcblx0XHRcdHRoaXMuc2VsZWN0ZWRFeWVwaWVjZXMuc3BsaWNlKGluZGV4LCAxKTtcblx0XHRcdHRoaXMuc2VsZWN0ZWRFeWVwaWVjZXNNYXAuc3BsaWNlKGluZGV4LCAxKTtcblx0XHR9LFxuXHRcdGNsZWFyU2VsZWN0aW9uOiBmdW5jdGlvbiAoKSB7XG5cdFx0XHR0aGlzLnNlbGVjdGVkRXllcGllY2VzID0gW107XG5cdFx0XHR0aGlzLnNlbGVjdGVkRXllcGllY2VzTWFwID0gW107XG5cdFx0fSxcblx0XHRzZWFyY2g6IGZ1bmN0aW9uIChxdWVyeSkge1xuXHRcdFx0dGhpcy5zZWFyY2hSZXN1bHRzID0gc2VhcmNoKHRoaXMuZXllcGllY2VzLCBxdWVyeSk7XG5cdFx0fSxcblx0XHRjbGVhclNlYXJjaDogZnVuY3Rpb24gKCkge1xuXHRcdFx0dGhpcy5xdWVyeSA9IG51bGw7XG5cdFx0XHR0aGlzLnNlYXJjaCh0aGlzLnF1ZXJ5KTtcblx0XHR9LFxuXHRcdHRvZ2dsZVB1cGlsUmVmZXJlbmNlOiBmdW5jdGlvbiAoKSB7XG5cdFx0XHR0aGlzLnB1cGlsUmVmZXJlbmNlID0gIXRoaXMucHVwaWxSZWZlcmVuY2U7XG5cdFx0fVxuXHR9LFxuXHRmaWx0ZXJzOiB7XG5cdFx0YXBwZW5kOiBhcHBlbmQsXG5cdFx0bW06IGFwcGVuZC5iaW5kKG51bGwsICcgbW0nKSxcblx0XHRkZWc6IGFwcGVuZC5iaW5kKG51bGwsICfCsCcpLFxuXHRcdG1hZzogYXBwZW5kLmJpbmQobnVsbCwgJ3gnKSxcblx0XHRudW1iZXJGb3JtYXQ6IG51bWJlckZvcm1hdFxuXHR9XG59KTtcblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9qcy9leWVwaWVjZS1mb3JtLmpzIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ }
/******/ ]);