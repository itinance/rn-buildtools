# rn-buildtools
a collection of our inhouse buildtools for react-native

## extractPackages.js

this script extracts all dependencies from package.json into a simple text file.

Simple run this script into your RN-project-rootfolder:

```shell
$> node extractPackages.js
```

## add.php

Installation: copy this file under /usr/local/bin and give it executable permissions:

chmod u+x /usr/local/bin/add.php

This script does the following:

- installing the library if not already existing under node_modules
- linking with `react-native link $dep` if it contains native code
- rebuilding the whole android-application

Example:

```shell
add.php react-native-fs
```

It can also work with a text-file that contains a list of all dependencies line by line.

## Rebuild your app and checkout if libraries could be build for android:

```shell
node extractPackages.js > /tmp/deps
add.php /tmp/deps
```

This will iterate over every dependency and will build your application with gadle.
If a library makes trouble it will stop. This way you can identify problematic libraries.

## Copyright

(C) 2017 Hagen Hübel / ITinance GmbH
Use at your own risk.

Pull requests are welcome.

