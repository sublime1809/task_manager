(function() {
	var tasks = angular.module('tasks', []);

	tasks.controller('tasksController', ['$scope', 'taskFactory', function($scope, taskFactory) {
		$scope.tasks = [];
		$scope.task = {};

		getTasks();

		function getTasks() {
			taskFactory.getTasks().then(function(response) {
				$scope.tasks = response.data;
			}, function(error) {
				console.log('ERROR', error);
			});
		}

		$scope.getTask = function(id) {
			taskFactory.getTask(id).then(function(response) {
				for (task_index in $scope.tasks) {
					if ($scope.tasks[task_index].id == id) {
						$scope.tasks[task_index] = response.data;
					}
				}
			}, function(error) {
				console.log('ERROR', error);
			});
		}

		$scope.deleteTask = function(id) {
			taskFactory.deleteTask(id).then(function(response) {
				for (task_index in $scope.tasks) {
					task_index = parseInt(task_index);
					console.log(task_index);
					if ($scope.tasks[task_index].id == id) {
						$scope.tasks.splice(task_index, 1);
					}
				}
			}, function(error) {
				console.log('ERROR', error);
			});
		}

		$scope.createTask = function(name) {
			taskFactory.createTask(name).then(function(response) {
				$scope.tasks.push(response.data);
				$scope.task = {};
			}, function(error) {
				console.log('Error', error);
			});
		}

		$scope.completeTask = function(id) {
			taskFactory.completeTask(id).then(function(response) {
				for (task_index in $scope.tasks) {
					if ($scope.tasks[task_index].id == id) {
						$scope.tasks[task_index] = response.data;
					}
				}
			}, function(error) {
				console.log('ERROR', error);
			});
		}

		$scope.uncompleteTask = function(id) {
			taskFactory.uncompleteTask(id).then(function(response) {
				for (task_index in $scope.tasks) {
					if ($scope.tasks[task_index].id == id) {
						$scope.tasks[task_index] = response.data;
					}
				}
			}, function(error) {
				console.log('ERROR', error);
			});
		}
	}]);
	tasks.directive('tasks', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/tasks.html',
			controller: 'tasksController',
			controllerAs: 'tasks'
		}
	});

	tasks.factory('taskFactory', ['$http', function($http) {
		var taskApiUrl = 'http://localhost:8080/task/';
		var taskFactory = {};

		taskFactory.getTasks = function() {
			return $http.get(taskApiUrl);
		}
		taskFactory.getTask = function(id) {
			return $http.jsonp(taskApiUrl + id);
		}
		taskFactory.deleteTask = function(id) {
			return $http.delete(taskApiUrl + id);
		}
		taskFactory.completeTask = function(id) {
			return $http.post(taskApiUrl + id, {'completed_at': Date.now()});
		}
		taskFactory.uncompleteTask = function(id) {
			return $http.post(taskApiUrl + id, {'completed_at': null});
		}
		taskFactory.createTask = function(name) {
			return $http.put(taskApiUrl, {'name': name});
		}

		return taskFactory;
	}]);
})();