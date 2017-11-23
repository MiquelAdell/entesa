#!/usr/bin/env bash
#rsync -aphvP /Users/miqueladell/code/VVV/www/entesa/htdocs/wp-content/themes miqueladell@miqueladell.cat:/home/miqueladell/entesa.miqueladell.com/wp-content/
rsync -aphvP /Users/miqueladell/code/VVV/www/entesa/htdocs/wp-content/uploads entesa@entesa.org:/home/entesa/public_html/wp-content/
rsync -aphvP /Users/miqueladell/code/VVV/www/entesa/htdocs/wp-content/plugins entesa@entesa.org:/home/entesa/public_html/wp-content/
