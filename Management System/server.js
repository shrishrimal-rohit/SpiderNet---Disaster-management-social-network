const express = require('express');
app = express();
var bodyParser = require('body-parser');
app.use(bodyParser.json()); // support json encoded bodies
app.use(bodyParser.urlencoded({ extended: true })); // support encoded bodies
console.log("Listening")
app.listen(8080, function() {
  //console.log('listening on 8080')
})

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/manage_page.html')
})

const fs = require('fs');
app.post('/add', (req, res) => {

  // Open json
  // Read in a buffer string
  // Marshell into json object
  // fh = open("ossn.config.json") 
  // json_str = read (fh)
  // json_obj = json.loads(json_str)
  // json_obj["username"] = req.params.username
  fs.writeFileSync('some_users.json',JSON.stringify(req.body));
  res.end('add done');

 });

app.post('/list', (req, res) => {
res.sendFile('/home/ec2-user/smartnet/list.html');
});

app.post('/dashboard', (req, res) => {
res.sendFile('/home/ec2-user/smartnet/dashboard.html');
});

app.post('/create', (req, res) => {
  console.log("post")
  console.log(req.body.ins)
  req.connection.setTimeout( 1000 * 60 * 10 );
var spawn = require('child_process').spawn;
var process = spawn('python',["/home/ec2-user/smartnet/create_instance.py",req.body.ins]);

process.stdout.on('data', (data) => {
  console.log(`stdout: ${data}`);
});

process.stderr.on('data', (data) => {
  console.log(`stderr: ${data}`);
});

process.on('close', (code) => {
  console.log(`child process exited with code ${code}`);
  res.end('Requested instances  created');
});
})
