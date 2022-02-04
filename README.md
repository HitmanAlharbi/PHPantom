# PHPantom

- PHPantom is a PHP class to monitor the dangerous functions in the code 

- It prints the code line of the called function

- It checks if the line has an input or not (Not accurate 100%)

- PHPantom is based on "Xdebug extension", so you need to install first ..

![image](https://user-images.githubusercontent.com/36328177/152566608-044f1e02-0145-46f1-b815-654eab40b013.png)


# How to install Xdebug extension for PHP?

- If your system is linux, please follow these steps :

1. sudo apt-get install php-xdebug
 
2. find / -name "xdebug.so"

3. sudo nano /etc/php/8.0/mods-available/xdebug.ini

4. Update zend_extension=/your/full/path/xdebug.so


- If you are using another OS, please visit the link:

- [How to install Xdebug extension](https://xdebug.org/docs/install)


# How to use PHPantom class

- Add the PHPantom.php file in the same folder of the target application

- Then write the call code in the top of the index or main file

```php
include("PHPantom.php");
$phpantom = new PHPantom();
```

- Visit the main page to see the result on the bottom of the page

- If you want to pass custom functions, write it like this


```php
include("PHPantom.php");
$phpantom = new PHPantom(["system", "exec", "eval"]);
```

# Youtube video tutorial [Arabic]

- https://www.youtube.com/watch?v=KvIBfn56P3U

# Twitter

- https://twitter.com/hitmanf15
