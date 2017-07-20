var fs = require('fs');

const destination = '/tmp/cooblr/cooblr/package.json'

fs.readFile('package.json', 'utf8', function (err,data) {
  if (err) {
    return console.log(err);
  }

  let json = JSON.parse(data);
  const depsNode = json.dependencies;

  const keys = Object.keys(depsNode)
  keys.forEach( (key) => {
    console.log(key)
  })
  
});
