<?php /* Smarty version 2.6.29, created on 2017-10-23 04:08:12
         compiled from C:%5Cxampp%5Chtdocs%5CPortal_del_Vecino%5CPortal_del_Vecino%5Cpublic_html%5Cmodulos%5Cforo/applications/dashboard/views/popup.master.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'asset', 'C:\\xampp\\htdocs\\Portal_del_Vecino\\Portal_del_Vecino\\public_html\\modulos\\foro/applications/dashboard/views/popup.master.tpl', 4, false),array('function', 'event', 'C:\\xampp\\htdocs\\Portal_del_Vecino\\Portal_del_Vecino\\public_html\\modulos\\foro/applications/dashboard/views/popup.master.tpl', 9, false),)), $this); ?>
<!DOCTYPE html>
<html lang="<?php echo $this->_tpl_vars['CurrentLocale']['Lang']; ?>
">
<head>
    <?php echo smarty_function_asset(array('name' => 'Head'), $this);?>

</head>
<body id="<?php echo $this->_tpl_vars['BodyID']; ?>
" class="PopupPage <?php echo $this->_tpl_vars['BodyClass']; ?>
">
<div id="Content"><?php echo smarty_function_asset(array('name' => 'Content'), $this);?>
</div>
<?php echo smarty_function_asset(array('name' => 'Foot'), $this);?>

<?php echo smarty_function_event(array('name' => 'AfterBody'), $this);?>

</body>
</html>