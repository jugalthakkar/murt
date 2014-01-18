
// JSLint options:
/*global Highcharts, angular, document, window, navigator, setInterval, clearInterval, clearTimeout, setTimeout, location, jQuery, $, console, each, grep*/
/*jslint  indent: 4*/

angular.module('resultFilterDirective', ['ngAnimate'])
        .directive('murtResultFilter', function() {
            'use strict';
            return {
                restrict: 'A',
                replace: false,
                scope: {
                    allItems: '=',
                    filteredItems: '=',
                    titleProperty: '=',
                    save: '&',
                    cancel: '&'
                },
                templateUrl: 'partials/directives/murt-result-filter.html',
                controller: ResultFilterController
            };
        });