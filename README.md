AnacondaPHP
===========

Anaconda.PHP adds PHP linting, PHP code standards checking and complexity/messing detector for your Sublime Text 3 that uses anaconda's engine so it does not freezes your Sublime Text 3 ever.

## Dependencies

1. [Anaconda](https://github.com/DamnWidget/anaconda) plugin for Sublime Text 3
2. PHP Interpreter

## Installation

If [Anaconda](https://github.com/DamnWidget/anaconda) is not already installed you should install it using the `Palette Control`, if it is already installed, just skip to the next section

### Install Anaconda plugin

1. Show the Command Palette (`cmd+shift+p` on OS X or `ctrl+shift+p` on Linux/Windows) 
2. Type `install`, then select `Package Control: Install package` from the list of options
3. Type `anaconda` and press enter

### Install PHP

If you have PHP already installed in your system, just go forward to the next section.

There is too many ways to install php in different operating systems, is already installed in OS X and in the majority of the mainstream GNU/Linux distributions, please, refer to the [PHP Documentation](http://wwww.php.net) site to get details about how to install PHP in your operating system.

### Install AnacondaPHP plugin

1. Show the Command Palette (`cmd+shift+p` on OS X or `ctrl+shift+p` on Linux/Windows) 
2. Type `install`, then select `Package Control: Install package` from the list of options
3. Type `anaconda_php` and press enter

### And we are done 

Wait, all the others plugins to lint php code require to install [PEAR](http://pear.php.net/) and a couple of command line applications in manual way, does not anaconda_php require them?

Yes, it does, but everything is already built inside the plugin so you don't need to bother about install anything yourself. You are welcome :)

## Does AnacondaPHP autocomplete PHP code?

No it doesn't. Unfortunately there is no PHP autocompletion libraries (as the awesome Jedi that Anaconda uses for Python autocompletion), the only thing that I know that can be used to autocomplete PHP is [Exuberant CTags](http://ctags.sourceforge.net/), there is already a plugin to use CTags in Sublime Text, you can found it [here](https://github.com/SublimeText/CTags)

## How I configure the plugin?

Please, refer to the [Configuration file](https://raw.githubusercontent.com/DamnWidget/anaconda_php/master/AnacondaPHP.sublime-settings) it's all well documented.
