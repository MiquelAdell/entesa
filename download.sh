#!/usr/bin/env bash
rsync -aphvP miqueladell@miqueladell.cat:/home/miqueladell/entesa.miqueladell.com/wp-content/themes  /Users/miqueladell/code/vagrant-local/www/entesa/htdocs/wp-content/
rsync -aphvP miqueladell@miqueladell.cat:/home/miqueladell/entesa.miqueladell.com/wp-content/uploads /Users/miqueladell/code/vagrant-local/www/entesa/htdocs/wp-content/
rsync -aphvP miqueladell@miqueladell.cat:/home/miqueladell/entesa.miqueladell.com/wp-content/plugins /Users/miqueladell/code/vagrant-local/www/entesa/htdocs/wp-content/
