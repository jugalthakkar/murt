/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var weekday = new Array(7);
weekday[0] = "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";
var months = new Array();
months[0] = "January";
months[1] = "February";
months[2] = "March";
months[3] = "April";
months[4] = "May";
months[5] = "June";
months[6] = "July";
months[7] = "August";
months[8] = "September";
months[9] = "October";
months[10] = "November";
months[11] = "December";
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

var defaultCharts = [
    {groupA: 'day', groupB: 'year'},
    {groupA: 'hour', groupB: 'month'},
    {groupA: 'date', groupB: 'year'}
];
var categoriesByGroup = {
    day: weekday,
    month: months,
    date: dates,
    hour: hours,
    year: years
};
function VisualizationCtrl($scope, Result) {

    Result.query({}, function(response) {

        $scope.allResults = [];
        _.each(response, function(result) {
            var examNameLowerCase = result.ExamName.toLowerCase();
            result.searchString = examNameLowerCase.replace(/[^a-z0-9]+/g, '');
            var epochTime = parseInt(result.Discovered * 1000);
            var resultDate = new Date(epochTime);
            result.day = weekday[resultDate.getDay()];
            result.month = months[resultDate.getMonth()];
            result.year = resultDate.getFullYear() + "";
            result.date = resultDate.getDate() + "";
            result.hour = resultDate.getHours() + "";
            //if (result.year === 2012) {
            $scope.allResults.push(result);
            //}
        });
        $scope.groupingOptions = _.map(categoriesByGroup, function(value, key) {
            return key;
        });
        $scope.customGroupDefintion = {
            groupA: 'day',
            groupB: 'month'
        };
        $scope.selectedResults = $scope.allResults;
        $scope.sidebarURL = "partials/result.html";
        $scope.mainContentURL = "partials/results.html";
        $scope.addSelection = function(id) {
            var matches = _.find($scope.allResults, function(result) {
                return result.Id === id;
            });
            $scope.selectedResults = _.union($scope.selectedResults, matches);
            $scope.selectedResultsFilterText = '';
            $scope.filterSelectedResults($scope.selectedResultsFilterText);
            //$scope.$apply();
        };
        $scope.setGroupA = function(option) {
            $scope.customGroupDefintion.groupA = option;
        }
        $scope.setGroupB = function(option) {
            $scope.customGroupDefintion.groupB = option;
        }
        $scope.removeSelection = function(id) {
            var matches = _.find($scope.allResults, function(result) {
                return result.Id === id;
            });
            $scope.selectedResults = _.difference($scope.selectedResults, matches);
            $scope.selectedResultsFilterText = '';
            $scope.filterSelectedResults($scope.selectedResultsFilterText);
            //$scope.$apply();
        };
        $scope.removeAll = function() {
            $scope.selectedResults = [];
            $scope.selectedResultsFilterText = '';
            $scope.filterSelectedResults($scope.selectedResultsFilterText);
            //$scope.$apply();
        };
        $scope.allResultsFiltered = [];
        $scope.allResultsFilterText = '';
        $scope.filterAllResults = function(filterText) {
//$scope.$apply();
            //console.log($scope.allResultsFilterText);
            var key = filterText.toLowerCase();
            //console.log('filtering all: ' + key);
            var filteredResults = _.filter($scope.allResults, function(result) {
                return result.searchString.indexOf(key) >= 0;
            });
            //console.log(filteredResults.length);
            $scope.allResultsFiltered = _.sortBy(filteredResults, "Discovered").reverse();
        };
        $scope.selectedResultsFiltered = [];
        $scope.selectedResultsFilterText = '';
        $scope.filterSelectedResults = function(filterText) {
// $scope.$apply();
// console.log($scope.selectedResultsFilterText);
            var key = filterText.toLowerCase();
            //console.log('filtering selected: ' + key);
            var filteredResults = _.filter($scope.selectedResults, function(result) {
//console.log(arguments);
                return result.searchString.indexOf(key) >= 0;
            });
            $scope.selectedResultsFiltered = _.sortBy(filteredResults, "Discovered").reverse();
        };
        $scope.filterAllResults('');
        $scope.filterSelectedResults('');
        $scope.addChart = addChart;
        $scope.isStacked = true;
        $scope.isStackable = false;
        $scope.tabs = [];
        createCharts($scope.selectedResultsFiltered);
        setToggleStackLabel();

        $scope.ToggleStacking = function() {
            $scope.isStacked = !$scope.isStacked;
            _.each(Highcharts.charts, toggleStack);
            setToggleStackLabel();
        }
        $scope.showTab = showTab;
    });

    function setToggleStackLabel() {
        $scope.toggleStackLabel = $scope.isStacked ? 'Unstack' : 'Stack';
    }


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


    function createChart($container, series, groupDefinition) {
        series.push({
            type: 'pie',
            data: getAggregateData(series, groupDefinition.groupA),
            name: 'Overall',
            center: [100, 80],
            size: 150,
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        });
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

    function toggleStack(chart) {
        _.each(chart.series, function(serie) {
            if (serie.type === 'column') {
                if (serie.options.stacking === 'normal') {
                    serie.update({stacking: null}, false);
                } else {
                    serie.update({stacking: 'normal'}, false);
                }

            }
        });
        chart.redraw();

    }

    function addChart(groupDefinition, results) {
        var dataByGroupA = {};
        _.each(categoriesByGroup[groupDefinition.groupB], function(value) {
            dataByGroupA[value] = _.filter(results, function(result) {
                return result[groupDefinition.groupB] === value;
            });
        });
        var series = [];
        _.each(dataByGroupA, function(thisGroupResults, groupKey) {
            series.push({type: 'column', stacking: 'normal', name: groupKey, data: createSeriesData(thisGroupResults, groupDefinition.groupA)});
        });
        var paneId = "chart-" + groupDefinition.groupA + "-" + groupDefinition.groupB + "-container";
        $scope.tabs.push({
            header: toTitleCase('By ' + groupDefinition.groupA + ' & ' + groupDefinition.groupB),
            containerId: paneId
        });

        setTimeout(function() {
            createChart($('#' + paneId + ' .chartContainer'), series, groupDefinition)
            showTab(paneId);
        }, 100);
    }

    function showTab(paneId) {
        console.log(paneId);
        $('#' + paneId + '-link').tab('show');
        var $container = $('#' + paneId).find(".chartContainer");
        if ($container.length) {
            var chart = $container.highcharts();
            if (_.any(chart.series, function(serie) {
                return (serie.type === 'column');
            })) {
                $scope.isStackable = true;
            } else {
                $scope.isStackable = false;
            }
            chart.reflow(false);//         
        } else {
            $scope.isStackable = false;
        }

    }

    function createCharts(results) {

        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        _.each(defaultCharts, function(groupDefinition) {
            addChart(groupDefinition, results);
        });

        var timeLineData = _.map(results, function(result) {
            return [parseInt(result.Discovered) * 1000, 1];
        });
        timeLineData = _.sortBy(timeLineData, function(valuePair) {
            return valuePair[0];
        });
        var paneId = 'timeline'
        $("#" + paneId + " .chartContainer").highcharts("StockChart", {
            title: {text: 'Timeline'},
            series: [
                {
                    name: 'Results',
                    data: timeLineData,
                    type: 'area',
                    dataGrouping: {
                        forced: true,
                        approximation: 'sum',
                        units: [['day', [1]]]
                    }
                }
            ],
            credits: {
                text: 'Mumbai University Result Tracker',
                href: 'http://muresulttracker.tk/'
            },
            chart: {zoomType: 'x'}
        });

        showTab(paneId);
    }
}



