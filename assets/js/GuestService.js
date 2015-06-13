var GuestService = {

	list: [],
	
	add: function(guest, callback) {
		$.ajax({
			type: 'post',
			contentType: 'application/json',
			url: 'api/guest',
			data: JSON.stringify(guest),
			success: function(addedGuest){
				console.log('Guest created!');
				callback(addedGuest);
			},
			error: function(){
				console.log('Error to add guest ' + guest.name);
			}
		});
	},
	
	remove: function(id, callback) {
		$.ajax({
			type: 'DELETE',
			url: 'api/guest/' + id,
			success: function(response) {
				console.log('Guest deleted!');
				callback(true);
			},
			error: function(jqXHR) {
				console.log('Error to delete guest with id ' + id);
				callback(false);
			}
		});
	},
	
	getList: function(callback) {
		$.ajax({
			type: 'GET',
			url: 'api/guests',
			dataType: 'json',
			success: function(list) {
				callback(list);
			}
		});
	},
	
	saveToLocalStorage: function () {
		var listJson = JSON.stringify(GuestService.list);
		window.localStorage.setItem('guestlist', listJson);
	},
	
	retrieveFromLocalStorage: function () {
		var listJson = window.localStorage.getItem('guestlist');
		if(listJson) {
			GuestService.list = JSON.parse(listJson);
		}
	}
}