

angular.module('muChartDirective', [])


        .directive('murtChart', function() {


    function createChart(element, scope) {
        var $container = angular.element('<div class="chartContainer"></div>');
        element.empty().append($container);
        var series = getSeries(scope);
        var groupDefinition = {groupA: scope.groupA, groupB: scope.groupB};
        $container.highcharts({
            title: {
                text: toTitleCase('Results By ' + groupDefinition.groupA + ' & ' + groupDefinition.groupB)
            },
            labels: {
                items: [{
                        html: toTitleCase('Results By ' + groupDefinition.groupA),
                        style: {
                            left: '75px',
                            top: '3px',
                            color: 'black'
                        }
                    }]
            },
            series: series,
            xAxis: {
                categories: categoriesByGroup[groupDefinition.groupA]
            },
            yAxis: {
                title: {
                    text: 'No. of Results'
                }
            },
            credits: {
                text: 'Mumbai University Result Tracker',
                href: 'http://muresulttracker.tk/'
            }, tooltip: {
                shared: true
            },
        });
    }


    function foo(scope, element) {
        if (!scope.groupA || !scope.groupB || !scope.results) {
//            console.log('returned. groupA: ' + scope.groupA + ', groupB:' + scope.groupB + ', results: ' + scope.results);
            return;
        }
        var $container = angular.element('<div class="chartContainer"></div>');
        element.empty().append($container);
        createChart($container, getSeries(scope), {groupA: scope.groupA, groupB: scope.groupB});
    }

    var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var dates = [];
    for (var i = 1; i <= 31; i++) {
        dates.push(i + "");
    }

    var hours = [];
    for (var i = 0; i <= 23; i++) {
        hours.push(i + "");
    }

    var years = [];
    var thisYear = new Date().getFullYear();
    for (var i = 2010; i <= thisYear; i++) {
        years.push(i + "");
    }

    var categoriesByGroup = {
        day: weekday,
        month: months,
        date: dates,
        hour: hours,
        year: years
    };
    function createSeriesData(thisYearResults, groupingKey) {
        var data = [];
        _.each(categoriesByGroup[groupingKey], function(category) {
            var filteredResults = _.filter(thisYearResults, function(result) {
                return result[groupingKey] === category;
            });
            data.push({xCategory: category, y: filteredResults.length, results: filteredResults});
        });
        return data;
    }

    function getAggregateData(series, group) {
        var aggregateData = [];
        _.each(categoriesByGroup[group], function(category) {
            var categorySum = 0;
            _.each(series, function(serie) {
                categorySum += _.find(serie.data, function(datum) {
                    return datum.xCategory === category;
                }).y;
            });
            aggregateData.push({name: category, y: categorySum});
        });
        return aggregateData;
    }

    function toTitleCase(str) {
        return str.replace(/\w\S*/g, function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    }

    function getSeries(scope) {
        var dataByGroupA = {};
        var groupBCategories = categoriesByGroup[scope.groupB];
        _.each(groupBCategories, function(value) {
            dataByGroupA[value] = _.filter(scope.results, function(result) {
                return result[scope.groupB] === value;
            });
        });
        var series = [];
        _.each(dataByGroupA, function(thisGroupResults, groupKey) {
//To DO: stack
            series.push({type: 'column', stacking: true ? 'normal' : null, name: groupKey, data: createSeriesData(thisGroupResults, scope.groupA)});
        });
        series.push({
            type: 'pie',
            data: getAggregateData(series, scope.groupA),
            name: 'Overall',
            center: [100, 80],
            size: 150,
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        });
        return series;
    }



    return {
        restrict: 'A',
        replace: false,
        scope: {
            groupA: '=',
            groupB: '=',
            results: '='
        },
        link: function(scope, element, attrs, ChartDirectiveController) {
            function validate() {
                return (scope.groupA && scope.groupB && scope.results);
            }
            scope.$watch('groupA', function() {
                validate() && createChart(element, scope);
            });
            scope.$watch('groupB', function() {
                validate() && createChart(element, scope);
            });
            scope.$watch('results', function() {
                validate() && createChart(element, scope);
            });
        }
    };
});