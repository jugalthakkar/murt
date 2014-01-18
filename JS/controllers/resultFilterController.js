'use strict';

function ResultFilterController($scope) {
    $scope.searchText = '';
    $scope.$watch('searchText', search);



    $scope.updateFilteredItems = function() {
        $scope.filteredItemCount = _.countBy($scope.wrappedItems, 'selected').true || 0;
        reorderSearchResults();
    };



    $scope.done = function() {
        var filteredItems = _.where($scope.wrappedItems, {selected: true});
        filteredItems = _.sortBy(filteredItems, 'originalIndex');
        $scope.filteredItems = _.pluck(filteredItems, 'actualItem');

        $scope.save && $scope.save({filteredItems: $scope.filteredItems});
    };

    $scope.abort = function() {
        $scope.cancel && $scope.cancel();
    };


    $scope.removeAll = function() {
        _.each($scope.searchResults, function(item) {
            item.selected = false;
        });
        $scope.updateFilteredItems();
    };

    $scope.addAll = function() {
        _.each($scope.searchResults, function(item) {
            item.selected = true;
        });
        $scope.updateFilteredItems();
    };
    function search() {
        var keys = _.filter($scope.searchText.toLowerCase().split(' '), function(word) {
            return word.trim().length;
        });

        $scope.searchResults = _.filter($scope.wrappedItems, function(wrappedItem) {
            return _.all(keys, function(key) {
                return wrappedItem.searchString.indexOf(key) >= 0;
            });
        });
        reorderSearchResults();
    }
    function reorderSearchResults() {
        $scope.searchResults = _.sortBy($scope.searchResults, 'title');
        $scope.searchResults = _.sortBy($scope.searchResults, function(item) {
            return item.selected ? 0 : 1;
        });
    }
    $scope.$watchCollection('allItems', function() {
        if (!$scope.filteredItems) {
            $scope.filteredItems = [];
        }
        $scope.wrappedItems =
                _.map($scope.allItems, function(item, index) {
                    var title = item[$scope.titleProperty];
                    var isSelected = _.contains($scope.filteredItems, item);
                    return {
                        actualItem: item,
                        selected: isSelected,
                        title: title,
                        searchString: title.toLowerCase().replace(/[^a-z0-9]+/g, ''),
                        originalIndex: index
                    };
                });
        $scope.filteredItemCount = 0;
        $scope.searchText = '';
        search();
        $scope.updateFilteredItems();
    });


}