'use strict';

function VisualizationController($scope, ResultService) {

    function toTitleCase(str) {
        return str.replace(/\w\S*/g, function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    }

    $scope.filterMode = false;

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
        $scope.tabs = [];
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

    $scope.allResults = [];
    $scope.selectedResults = [];
    ResultService.query({}, function(response) {
        $scope.allResults = response;
        $scope.selectedResults = response;
        createCharts();
        $scope.loaded = true;
    });

    $scope.groupingOptions = ['day', 'month', 'date', 'hour', 'year'];
    $scope.customGroupDefintion = {
        groupA: 'day',
        groupB: 'month'
    };

    $scope.setGroupA = function(option) {
        $scope.customGroupDefintion.groupA = option;
    };
    $scope.setGroupB = function(option) {
        $scope.customGroupDefintion.groupB = option;
    };
    $scope.addChart = addColumnChart;
    $scope.isStacked = true;
    $scope.isStackable = false;
    $scope.tabs = [];

    $scope.showTab = showTab;
    $scope.disableStacking = function() {
        $scope.isStackable = false;
    };

    $scope.alerts = [];
    $scope.filter = function() {
        $scope.filterMode = true;
    };

    $scope.filterSave = function() {

        $scope.filterMode = false;
    };

    $scope.filterCancel = function() {

        $scope.filterMode = false;
    };

    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
    $scope.$watch('isStacked', function() {
        _.each($scope.tabs, function(tab) {
            tab.config.isStacked = $scope.isStacked;
        });
    });
}