angular.module('visualization', ['ngRoute', 'ResultServices', 'muChartDirective', 'ui.bootstrap']).config(visualizationRouter);

function visualizationRouter($routeProvider) {
    $routeProvider.when('/', {
        templateUrl: 'partials/visualization.html',
        controller: 'VisualizationController'}
    );
    $routeProvider.when('/chart', {
        templateUrl: 'partials/directives/chart.html',
        controller: 'ChartDirectiveController'}
    );
}