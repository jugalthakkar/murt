
// JSLint options:
/*global Highcharts, angular, document, window, navigator, setInterval, clearInterval, clearTimeout, setTimeout, location, jQuery, $, console, each, grep*/
/*jslint  indent: 4*/
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
angular.module('murtChartDirective', [])
        .directive('murtChart', function() {
            'use strict';


            return {
                restrict: 'A',
                replace: false,
                scope: {
                    config: '=',
                    results: '='
                },
                template: '<div class="chartContainer"></div>',
                controller: ChartDirectiveController,
                link: function(scope, element, attrs, controller) {
                    function validate() {
                        if (!scope.config || !scope.results || !scope.results.length) {
                            return false;
                        }
                        switch (scope.config.type) {
                            case 'column':
                                return (scope.config.groupA && scope.config.groupB && scope.results);
                            case 'timeline':
                                return scope.results;
                        }
                    }
                    function redraw() {
                        if (validate()) {
//                    console.log('redrawing: ' + scope.config.type + ' results: '+scope.results.length);
                            var $container = angular.element(element).find('.chartContainer');
                            var commonOptions = {
                                yAxis: {
                                    title: {
                                        text: 'No. of Results'
                                    }
                                },
                                chart: {
                                    width: $container.closest('.container').width()
                                },
                                credits: {
                                    text: 'Mumbai University Result Tracker',
                                    href: 'http://muresulttracker.tk/'
                                }, tooltip: {
                                    shared: true
                                }
                            };
                            switch (scope.config.type) {
                                case 'column':
                                    $container.highcharts(_.extend(scope.getColumnChartOptions(), commonOptions));
                                    break;
                                case 'timeline':
                                    $container.highcharts('StockChart', _.extend(scope.getTimelineOptions(), commonOptions));
                                    break;
                            }
                            $container.load(function() {
                                $container.highcharts().reflow();
                            });

                            var chart = $container.highcharts();
                            chart.hasUserSize = null;
                            chart.options.chart.width = null;
                            $(window).resize(function() {
                                //ToDo remove event
                                chart.reflow(false);
                            });
                        }
                    }

                    function onConfigChange(newValue, oldValue) {
                        if (oldValue !== newValue) {
                            redraw();
                        }
                    }
                    ;

                    scope.$watch('config', onConfigChange, true);
                    scope.$watchCollection('results', onConfigChange);
//            scope.$watch('config.isStacked', redraw);

                }
            };
        });