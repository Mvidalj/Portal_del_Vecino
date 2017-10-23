<?php if (!defined('APPLICATION')) exit();

// API
$Configuration['API']['Secret'] = 'c1ced446-b415-4863-9f34-3e881e621aeb';
$Configuration['API']['Version'] = '0.5.0';

// Conversations
$Configuration['Conversations']['Version'] = '2.3.1';

// Database
$Configuration['Database']['Name'] = 'vecino_foro';
$Configuration['Database']['Host'] = 'localhost';
$Configuration['Database']['User'] = 'root';
$Configuration['Database']['Password'] = '';

// EnabledApplications
$Configuration['EnabledApplications']['Conversations'] = 'conversations';
$Configuration['EnabledApplications']['Vanilla'] = 'vanilla';
$Configuration['EnabledApplications']['api'] = 'api';

// EnabledLocales
$Configuration['EnabledLocales']['vf_es'] = 'es';

// EnabledPlugins
$Configuration['EnabledPlugins']['GettingStarted'] = 'GettingStarted';
$Configuration['EnabledPlugins']['HtmLawed'] = 'HtmLawed';
$Configuration['EnabledPlugins']['vanillicon'] = true;
$Configuration['EnabledPlugins']['jsconnect'] = true;
$Configuration['EnabledPlugins']['jsconnectAutoSignIn'] = true;

// Garden
$Configuration['Garden']['Title'] = 'Foro para vecinos';
$Configuration['Garden']['Cookie']['Salt'] = 'l86mR4juK9H8ICUN';
$Configuration['Garden']['Cookie']['Domain'] = '';
$Configuration['Garden']['Registration']['ConfirmEmail'] = false;
$Configuration['Garden']['Registration']['Method'] = 'Connect';
$Configuration['Garden']['Registration']['InviteExpiration'] = '1 week';
$Configuration['Garden']['Registration']['CaptchaPrivateKey'] = '6LdVlzMUAAAAADkK6xvI265aM8P0b8e7SbxDF4eS';
$Configuration['Garden']['Registration']['CaptchaPublicKey'] = '6LdVlzMUAAAAABnDdoJhP4b7EkhG7VEhJbDA-4hc';
$Configuration['Garden']['Registration']['InviteRoles']['3'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['4'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['8'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['16'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['32'] = '0';
$Configuration['Garden']['Email']['SupportName'] = 'Foro para vecinos';
$Configuration['Garden']['Email']['Format'] = 'text';
$Configuration['Garden']['Email']['SupportAddress'] = 'matiasignaciomellado@hotmail.cl';
$Configuration['Garden']['Email']['UseSmtp'] = '1';
$Configuration['Garden']['Email']['SmtpHost'] = 'smtp.live.com';
$Configuration['Garden']['Email']['SmtpUser'] = 'matiasignaciomellado@hotmail.cl';
$Configuration['Garden']['Email']['SmtpPassword'] = 'holamatias190797';
$Configuration['Garden']['Email']['SmtpPort'] = '25';
$Configuration['Garden']['Email']['SmtpSecurity'] = 'tls';
$Configuration['Garden']['Email']['OmitToName'] = false;
$Configuration['Garden']['SystemUserID'] = '1';
$Configuration['Garden']['InputFormatter'] = 'Markdown';
$Configuration['Garden']['Version'] = '2.3.1';
$Configuration['Garden']['Cdns']['Disable'] = false;
$Configuration['Garden']['CanProcessImages'] = true;
$Configuration['Garden']['Installed'] = true;
$Configuration['Garden']['Theme'] = 'bittersweet';
$Configuration['Garden']['Locale'] = 'es';
$Configuration['Garden']['Embed']['Allow'] = false;

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Registration'] = '1';
$Configuration['Plugins']['GettingStarted']['Categories'] = '1';
$Configuration['Plugins']['Vanillicon']['Type'] = 'v2';

// Routes
$Configuration['Routes']['DefaultController'] = 'discussions';

// Vanilla
$Configuration['Vanilla']['Version'] = '2.3.1';

// Last edited by admin (127.0.0.1)2017-10-23 04:27:42