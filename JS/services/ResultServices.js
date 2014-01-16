/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
angular.module('ResultServices', ['ngResource'])
        .factory('ResultService', function($resource) {
    return $resource('/jugal.me/murt/Services.php', {s: 'get'});
}
);
