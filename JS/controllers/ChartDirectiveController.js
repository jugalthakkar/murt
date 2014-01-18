'use strict';

var ChartDirectiveController = function($scope) {
    $scope.getColumnChartOptions = (function() {

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

        function process(results) {
            var processedResults = [];
            _.each(results, function(result) {
                var clonedResult = _.clone(result);
                var epochTime = parseInt(clonedResult.Discovered * 1000);
                var resultDate = new Date(epochTime);
                clonedResult.day = categoriesByGroup.day[resultDate.getDay()];
                clonedResult.month = categoriesByGroup.month[resultDate.getMonth()];
                clonedResult.year = resultDate.getFullYear() + "";
                clonedResult.date = resultDate.getDate() + "";
                clonedResult.hour = resultDate.getHours() + "";
                processedResults.push(clonedResult);
            });
            return processedResults;
        }

        function getColumnSeries(config, results) {
            var dataByGroupA = {};
            var groupBCategories = categoriesByGroup[config.groupB];
            _.each(groupBCategories, function(value) {
                dataByGroupA[value] = _.filter(process(results), function(result) {
                    return result[config.groupB] === value;
                });
            });
            var series = [];
            _.each(dataByGroupA, function(thisGroupResults, groupKey) {
                series.push({type: 'column', stacking: config.isStacked ? 'normal' : null, name: groupKey, data: createSeriesData(thisGroupResults, config.groupA)});
            });
            series.push({
                type: 'pie',
                data: getAggregateData(series, config.groupA),
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

        return function() {
            var config = $scope.config;
            var series = getColumnSeries($scope.config, $scope.results);
            return {
                title: {
                    text: toTitleCase('Results By ' + config.groupA + ' & ' + config.groupB)
                },
                labels: {
                    items: [{
                            html: toTitleCase('Results By ' + config.groupA),
                            style: {
                                left: '75px',
                                top: '3px',
                                color: 'black'
                            }
                        }]
                },
                series: series,
                xAxis: {
                    categories: categoriesByGroup[config.groupA]
                }
            };
        };
    })();


    $scope.getTimelineOptions = function() {
        var timeLineData = _.map($scope.results, function(result) {
            return [parseInt(result.Discovered) * 1000, 1];
        });
        timeLineData = _.sortBy(timeLineData, function(valuePair) {
            return valuePair[0];
        });
        return {
            title: {text: 'Timeline'},
            series: [
                {
                    name: 'Results',
                    data: timeLineData,
                    type: 'column',
                    dataGrouping: {
                        forced: true,
                        approximation: 'sum',
                        units: [[
                                'day',
                                [1]
                            ], [
                                'week',
                                [1]
                            ], [
                                'month',
                                [1, 3, 6]
                            ]]
                    }
                }
            ],
            chart: {
                zoomType: 'x'
            },
            rangeSelector: {
                selected: 4
            },
            xAxis: {
                ordinal: false
            }
        };
    };
};

