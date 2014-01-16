
// JSLint options:
/*global Highcharts, angular, document, window, navigator, setInterval, clearInterval, clearTimeout, setTimeout, location, jQuery, $, console, each, grep*/
/*jslint  indent: 4*/
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
angular.module('muChartDirective', [])
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
                if (!scope.config) {
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
                        chart.reflow(false);
                    });
                }
            }
            scope.$watch('config', redraw);
            scope.$watch('config.isStacked', redraw);

        }
    };
});