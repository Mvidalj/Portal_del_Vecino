<?php /* Smarty version 2.6.29, created on 2017-10-09 16:08:16
         compiled from C:%5Cxampp%5Chtdocs%5CPortal_del_Vecino%5CPortal_del_Vecino%5Cpublic_html%5Cmodulos%5Cforo/applications/dashboard/views/empty.master.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'asset', 'C:\\xampp\\htdocs\\Portal_del_Vecino\\Portal_del_Vecino\\public_html\\modulos\\foro/applications/dashboard/views/empty.master.tpl', 7, false),array('function', 'event', 'C:\\xampp\\htdocs\\Portal_del_Vecino\\Portal_del_Vecino\\public_html\\modulos\\foro/applications/dashboard/views/empty.master.tpl', 12, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="utf-8"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->_tpl_vars['CurrentLocale']['Lang']; ?>
">
<head>
    <?php echo smarty_function_asset(array('name' => 'Head'), $this);?>

</head>
<body id="<?php echo $this->_tpl_vars['BodyID']; ?>
" class="<?php echo $this->_tpl_vars['BodyClass']; ?>
">
<div id="Content"><?php echo smarty_function_asset(array('name' => 'Content'), $this);?>
</div>
<?php echo smarty_function_asset(array('name' => 'Foot'), $this);?>

<?php echo smarty_function_event(array('name' => 'AfterBody'), $this);?>

</body>
</html>