var express = require('express'),
	app = express();
	
const PORT = 3000,
	DOMAIN = 'http://localhost';	

app.use(express.static('public'));

app.get('/', function(request, response) {
	response.status(status).send('hello.');
});

var server = app.listen(PORT, function() {
	console.log('Server listening on: %s:%s', DOMAIN, PORT);
});
