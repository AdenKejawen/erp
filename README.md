Gatot Kaca Erp Project
================================

How To Install
--------------------------------
1. Install Postgre SQL

2. Edit app/config/paramter.yml

3. Update Vendor
php composer.phar self-update
php composer.phar update

4. Update Configuration
php app/console doctrine:database:create
php app/console doctrine:schema:update --force

To Run This Project Change
--------------------------------

<script type="text/javascript">
var ROOTDIR         = 'assets/';
var APPDIR          = 'bundles/gatotkacaerpmain/';
</script>

To

<script type="text/javascript">
var ROOTDIR         = 'assets/';
var APPDIR          = ROOTDIR;
</script>