#!/usr/bin/env bash
rsync -aphvP /Users/miqueladell/code/vagrant-local/www/entesa/htdocs/wp-content/themes miqueladell@miqueladell.cat:/home/miqueladell/entesa.miqueladell.com/wp-content/
rsync -aphvP /Users/miqueladell/code/vagrant-local/www/entesa/htdocs/wp-content/uploads miqueladell@miqueladell.cat:/home/miqueladell/entesa.miqueladell.com/wp-content/
rsync -aphvP /Users/miqueladell/code/vagrant-local/www/entesa/htdocs/wp-content/plugins miqueladell@miqueladell.cat:/home/miqueladell/entesa.miqueladell.com/wp-content/
