'use strict';

function VisualizationController($scope, ResultService) {

    ResultService.query({}, function(response) {

        $scope.allResults = [];
        _.each(response, function(result) {
            var examNameLowerCase = result.ExamName.toLowerCase();
            result.searchString = examNameLowerCase.replace(/[^a-z0-9]+/g, '');
            $scope.allResults.push(result);
        });
        $scope.groupingOptions = ['day', 'month', 'date', 'hour', 'year'];
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
        $scope.addChart = addColumnChart;
        $scope.isStacked = true;
        $scope.isStackable = false;
        $scope.tabs = [];
        createCharts($scope.selectedResultsFiltered);

        $scope.showTab = showTab;
        $scope.disableStacking = function() {
            $scope.isStackable = false;
        }

        $scope.alerts = [];
        $scope.filter = function() {
            $scope.alerts.push({type: 'info', msg: 'Filters will be available very soon. Stay Tuned!'});
        };


        $scope.closeAlert = function(index) {
            $scope.alerts.splice(index, 1);
        };
        $scope.$watch('isStacked', function() {
            _.each($scope.tabs, function(tab) {
                tab.config.isStacked = $scope.isStacked;
            });
        });
    });

    function toTitleCase(str) {
        return str.replace(/\w\S*/g, function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    }
    function addColumnChart(groupDefinition) {
        var newTab = {
            config: {
                type: 'column',
                groupA: groupDefinition.groupA,
                groupB: groupDefinition.groupB,
                isStacked: $scope.isStacked
            },
            header: toTitleCase('By ' + groupDefinition.groupA + ' & ' + groupDefinition.groupB)
        };
        $scope.tabs.push(newTab);
        showTab(newTab);
    }

    function addTimelineChart() {
        var newTab = {
            config: {
                type: 'timeline',
                isStacked: $scope.isStacked
            },
            header: 'Timeline',
            id: 'chart-timeline'
        };
        $scope.tabs.push(newTab);
        showTab(newTab);
    }

    function showTab(tab) {
        tab.active = true;
        $scope.isStackable = (tab.config && tab.config.type === 'column');
    }

    function createCharts() {
        var defaultCharts = [
            {groupA: 'day', groupB: 'year'},
            {groupA: 'hour', groupB: 'month'},
            {groupA: 'date', groupB: 'year'}
        ];

        addTimelineChart();
        _.each(defaultCharts, function(groupDefinition) {
            addColumnChart(groupDefinition);
        });
        _.each($scope.tabs, function(tab) {
            tab.active = false;
        });
        showTab($scope.tabs[0]);
    }
}