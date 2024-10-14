<?php
/**
 * config.php
 *
 * Michelle Bachler (KMi)
 *
 */

/**
 * Does this site require login for all access, including interface and API
 * true if it does, else false if it does not.
 */
$CFG->privateSite = false;

/**
 * This is the date you setup your Hub.
 * It is currently used by the site Analytics.
 * e.g. mktime(0, 0, 0, 7, 01, 2016) = 1st July 2016
 * Just edit the last three number month, date, year
 */
$CFG->START_DATE = 	mktime(0, 0, 0, 01, 01, 2016);

/**
 * Put your site title here.
 * This is used in the header title as well as being displayed to the user in various places '/'
 */
$CFG->SITE_TITLE = "Evidence Hub";

/**
 * You can get the following two user ids from the adddefaultdata.php script output, or
 * from the Users table in the database after the script has run
 */
// This person is the owner of the Theme nodes in the system and you have to log in as them to manage themes.
$CFG->ADMIN_USERID = "";

// This person acts as a template for new users. Thier node and link types are copied into new user accounts.
$CFG->defaultUserID = "";


/** NODE TYPES **/

// These are the basic node types for the Evidence Hub Datamodel.
// There is some flexibility. You can if you chose remove Challenge.
// You can choose to remove Idea (Open Comments)
// You can also choose to remove either Solution or Claim, but not both.
// If you remove both the site will not work. If you remove any other node types the site will not work properly.
$CFG->BASE_TYPES = array("Challenge","Issue","Solution","Claim","Organization","Project","Theme","Idea");

// These are the default Evidence Types.
// If you have changed them when you installed your default data please edit these to be
// exactly the same as your Evidence Type names in the database.
$CFG->EVIDENCE_TYPES = array("Anecdote","Case Study","Policy","Report","Research Finding");

// These are the default Resource Types.
// If you have changed them when you installed your default data please edit these to be
// exactly the same as your Resource Type names in the database.
$CFG->RESOURCE_TYPES = array("Publication","Web Resource");

// This is the default Evidence Type selected in the interface.
// This must match one of the Evidence Types listed in the EVIDENCE_TYPES property above.
$CFG->EVIDENCE_TYPES_DEFAULT = "Anecdote";

// This is the default Resource Type selected in the interface.
// This must match one of the Resource Types listed in the RESOURCE_TYPES property above.
$CFG->RESOURCE_TYPES_DEFAULT = "Web Resource";


/** URL SETUP **/

// home address is the base url for the website and must end with trailing '/'
// e.g. http://hubdev.kmi.open.ac.uk/
$CFG->homeAddress = "http://";

/** DATABASE SETUP **/

// The type of database. Currently we only have MySQL
$CFG->databasetype = "mysql";

// The database address, e.g. localhost or a url etc.
$CFG->databaseaddress = "localhost";

// The database username that Cohere uses to login to the database
$CFG->databaseuser= "";

// The database password to go with the above username
$CFG->databasepass = "";

// The database name for the Evidence Hub is to use
$CFG->databasename = "";


/** LANGUAGE **/

// This string indicates what language the interface text should use.
// The name must correspnd to a folder in the 'language' folder where the translated texts should exist.
$CFG->language = 'en';

// Country name as it appears in the language/<your language as above>/countries.php list to used as
// the default selection in Countries menus.
// If you change the language used you must also change this text.
$CFG->defaultcountry = "United Kingdom";

/** INTERFACE THEME **/

// This string indicates what theme the interface should use.
// The name must correspond to a folder in the 'theme' folder where the theme specific style sheets, images and pages should exist.
// The default theme is 'deault'. Make sure this is never deleted as it is the fall back position.
$CFG->uitheme = 'default';

/** BITS AND PIECES **/

// The path to a temp directory that the Evidence Hub can use
$CFG->workdir = "/tmp/";

/**
 * This paramter dictates who can build a new item from a Chat or Open Comment:
 * There are three option you can change this parameter to.
 * $CFG->BUILD_FROM_COMMENTS_USER, where only the Owner of a chat or open comment can build another item from it
 * $CFG->BUILD_FROM_COMMENTS_ADMIN, where only the Owner of a chat or open comment, or an Admin person can build naother item from it
 * $CFG->BUILD_FROM_COMMENTS_ALL, where anyone logged in can build naother item from it
 * The default is $CFG->BUILD_FROM_COMMENTS_ALL
 */
$CFG->build_from_permissions = $CFG->BUILD_FROM_COMMENTS_ALL;

// Should the site stats be visible to everyone (set to true), or just the Admins (set to false)
// Default is true;
$CFG->areStatsPublic = true;

// If true, it draw recommedation widgets on the explore pages,
// If false, it does NOT draw recommendation widgets on the explore pages.
$CFG->hasRecommendations = true;

// if true, all users will automatically follow their own items.
// if false, they will not.
$CFG->autoFollowingOn = false;

// If true, it draw Organizations/Projects/Users as one tab called 'Social' with a rollover menu for the three options,
// If false, it draws them as separate tabs.
$CFG->hasSocialTab = false;

// If true, only admins can add new issues. Default is false.
$CFG->issuesManaged = false;

// If true, it shows the debate button on explore for Issues. False to not show
// defaults to false;
$CFG->hasIssueDebateView = false;

// Does the hub have the link to the Story forms or not
// default is true
$CFG->hasStories = true;

// If true, you get RSS feed buttons at various places in the site,
// If false, you get no RSS feed buttons.
$CFG->hasRss = true;

// Does this site want to use a Compendium import ('true' / 'false').
// Note: the default import will need to be modified to match any site specific changes.
// So leave this false unless you know what you are doing.
$CFG->hasCompendiumImport = false;

// Does this site want to use a Bib TeX import ('true' / 'false').
$CFG->hasBibTexImport = true;

// Does this site want to have the homepage field on the user registration/profile forms.
$CFG->hasUserHomePageOption = true;

// Does this site want to display a Conditions of use Agreement statement when user's sign up?
// The default text for this can be overriden in a language custom folder (see the setup notes for more details).
$CFG->hasConditionsOfUseAgreement = false;

// How many tags to show in the home page tag cloud.
// We set 20 as the default.
$CFG->homeTagCount = 20;

/**
 * The following two values work together
 * For example if the debateCountOpen is 1 and the debateChildCount Open is 10,
 * then on the knowledge builder explore page, a knowledge tree will be opened automatically
 * when the page is loaded only if there is only 1 tree with less than 10 items on it, otherwise trees will be closed.
 */
// this value determines how many knowledge trees there should be
// to decide if they should be opened automoatcially.
$CFG->debateCountOpen = 1;

// This value determines how many items they should be less than in a knowledge tree to open it automatically.
$CFG->debateChildCountOpen = 10;

/**
 * The following two values work together
 * For example if the chatCountOpen is 1 and the chatChildCount Open is 15,
 * then on the Chats explore page, a chat tree will be opened automatically
 * when the page is loaded only if there is only 1 tree with less than 10 items on it, otherwise trees will be closed.
 */
// this value determines how many chat trees there should be
// to decide if they should be opened automoatcially.
$CFG->chatCountOpen = 1;

// This value determines how many items they should be less than in a chat tree to open it automatically.
$CFG->chatChildCountOpen = 15;

// Whether the Chat pages should have polling refreshing on or off
$CFG->chatPollingOn = true;

// If chat polling is on, this is the refresh rate in milliseconds.
// Defaults 60000 = 1 minute
$CFG->chatPollingInterval =  60000;

// We supply a default movie about the eviednce Hub.
// If you want the Homepage to show a different movie, change this link.
$CFG->welcomeMovie = "http://www.youtube.com/watch?feature=player_embedded&v=0fB2Kd2La8g";


/** SITE REGISTRATION **/
// whether or not the site is open for registration

/**
 * SITE REGISTRATION
 *
 * Whether or not the site is open for registration.
 * There are three option you can change this parameter to:
 * $CFG->SIGNUP_OPEN, If you use this state for signup, then users can register themselves for using the Hub
 * $CFG->SIGNUP_REQUEST, If you use this state for signup below, then users can request an account
 * 		for using the Hub which is then validated by a Hub Admin user.
 * $CFG->SIGNUP_CLOSED, If you use this state for signup below, then users cannot register,
 * 		they must be sent login details. So by invitation only.
 * The deault is $CFG->SIGNUP_CLOSED;
 */
$CFG->signupstatus = $CFG->SIGNUP_CLOSED;

// The email address of the Hub user managing the registration requests if SIGNUP_REQUEST is used.
// They must be ad admin user (IsAdmin set to 'Y' in Users table the database))
// defaults to $CFG->EMAIL_REPLY_TO
$CFG->signuprequestemail = '';

/**
 * NETWORK NODE COLOURS
 *
 * These are the background colours used in the Network Applet
 * They have the same names as styles in the styles.css file,
 * but we found we needed slightly darker shades for some that thier stylesheet equivalents.
 */
$CFG->challengebackpale = '#6FCBF5';
$CFG->issuebackpale = '#C6ECFE';
$CFG->solutionbackpale = '#E1F1C9';
$CFG->claimbackpale = '#ABCD7B';
$CFG->orgbackpale = '#A4AED4';
$CFG->projectbackpale = '#DEE2F0';
$CFG->peoplebackpale = '#EAECF5';
$CFG->evidencebackpale ='#DFC7EB';
$CFG->resourcebackpale = '#D8DA42';
$CFG->themebackpale = '#FAB8DA';
$CFG->plainbackpale = '#D0D0D0';

/**
 * These are the background colours used in Analytics graphs
 * They need to be darker versions of the above colours, as the pale versions are too pale on a graph.
 */
$CFG->challengeback = '#067EB0';
$CFG->issueback = '#4CC1F2';
$CFG->solutionback = '#F2B48A';
$CFG->claimback = '#CD6119';
$CFG->orgback = '#5B70BD';
$CFG->projectback = '#94A5E4';
$CFG->peopleback = '#0000C0';
$CFG->evidenceback ='#BC84DC';
$CFG->resourceback = '#BCE482';
$CFG->themeback = '#F777B9';
$CFG->plainback = '#D0D0D0';

/** BROWSER BOOKMARKLET TOOL **/

// The name of the Tool for this site.
// A shortening of the main site name or something like that.
$CFG->buildername = "-Your Site- EH";

// This needs to be a unique single word key that is used before
// all function names in the tool to avoid clashing with any other scripts loaded in wepages.
$CFG->buildernamekey = "<your tool key - e.g. 'HubDev'>";


/**
 * For initializing the org geo map
 *
 * These default settings show the world, zoomed out.
 */
// The latitude to center the Organization/Project map on
$CFG->orggeomapdefaultlat = "17.383";

// The longtitude to center the Organization/Project map on
$CFG->orggeomapdefaultlong = "11.183";

// The zoom level to start Organization/Project map on
// 12 is quite zoomed out
$CFG->orggeomapdefaultzoom = "2";


/**
 * For initializing the user geo map
 *
 * These default settings show the world, zoomed out.
 */
// The latitude to center the User map on
$CFG->usergeomapdefaultlat = "17.383";

// The longtitude to center the User map on
$CFG->usergeomapdefaultlong = "11.183";

// The zoom level to start the User map on. 2 is quite zoomed out.
$CFG->usergeomapdefaultzoom = "2";


/**
 * For initializing the user entries geo map
 *
 * These default settings show the world, zoomed out.
 */
// The latitude to center the User Entries map on
$CFG->usernodegeomapdefaultlat = "17.383";

// The longtitude to center the User Entries map on
$CFG->usernodegeomapdefaultlong = "11.183";

// The zoom level to start the User Entries map on. 2 is quite zoomed out.
$CFG->usernodegeomapdefaultzoom = "2";


/** EMAILING **/
// Whether or not to send emails.
// For example if your server can't do emailing - true/false, default 'true'
$CFG->send_mail = true;

// The email address to show system emails as being sent from
$CFG->EMAIL_FROM_ADDRESS = "";

// The email from name to show system emails as being sent by. Defaults to your site title plus 'Admin'
$CFG->EMAIL_FROM_NAME = $CFG->SITE_TITLE." Admin";

// The email address to sent system error alerts to. Usually your developer.
$CFG->ERROR_ALERT_RECIPIENT = "";

// The email address to show system emails should be replied to
$CFG->EMAIL_REPLY_TO = "";


/** NEWLETTERS AND EMAIL DIGESTS **/
// Should recent activity email sending should be included in this hub? (true/false);
$CFG->RECENT_EMAIL_SENDING_ON = true;

/**
 * PROXY SETTINGS
 *
 * if the server needs a proxy to access internet, set it here
 */
$CFG->PROXY_HOST = "";
$CFG->PROXY_PORT = "";


/** CAPTCHA **/
// If you want to use Capthca set this to 'true. ('true' or 'false')
// If this is set to 'true' you must also complete CAPTCHA_PUBLIC and CAPTCHA_PRIVATE below.
// We strongly recommend that you use Captch on your registration forms to stop automated registrations.
$CFG->CAPTCHA_ON = true;

// captcha public/private keys - olnet.org and subdomains - ci.
// You can get these from the Captcha website (https://www.google.com/recaptcha/admin)
$CFG->CAPTCHA_PUBLIC = "";
$CFG->CAPTCHA_PRIVATE = "";


/** GOOGLE **/

/*** Google Universal setup ***/
// Do you want to use Google Universal analytics. ('true' or 'false')
// If this is set to 'true' you must also complete the GOOGLE_ANALYTICS_KEY below.
$CFG->GOOGLE_ANALYTICS_ON = false;

// Google Universal analytics key
// You must get this from the Google Analytics website.
// If you set the GOOGLE_ANALYTICS_ON to 'true' you must add a key for it to work.#
$CFG->GOOGLE_ANALYTICS_KEY = "";

/*** Google Analytics 4 setup ***/
// Do you want to use Google Analytics 4. ('true' or 'false')
// If this is set to 'true' you must also complete the GOOGLE_ANALYTICS4_KEY below.
$CFG->GOOGLE_ANALYTICS4_ON = false;

// Google analytics 4 key
// You must get this from the Google Analytics website.
// If you set the GOOGLE_ANALYTICS4_ON to 'true' you must add a key for it to work.#
$CFG->GOOGLE_ANALYTICS4_KEY = "";

//For geo code look up
//https://docs.microsoft.com/en-us/bingmaps/rest-services/locations/find-a-location-by-query
//https://www.bingmapsportal.com/
$CFG->BINGMAPS_KEY = "";


/** MAILCHIMP NEWSLETTER SYSTEM **/
// Is MailChimp Newsletter service being used on this hub? (true/false)
$CFG->MAILCHIMP_ON = false;

// The main API Key for the Evidence Hub to use the MailChimp service you have set up
$CFG->MAILCHIMP_KEY = "";

// The MailChimp List id for the list you have setup for the Evidence Hub to subscribe users to
$CFG->MAILCHIMP_LISTID = "";

// If you want to point to an additional page with more information about your newsletter,
// put the url to use here. If this is empty, the link will not be displayed in the apporpraite pages.
$CFG->MAILCHIMP_NEWSLETTER_INFO_URL = "";


/**
 * urls that are allowed in IFrame and Object embeds in formatted descriptions
 * To add a new one repeat the pattern but increase the number, e.g.
 * $CFG->safeurls[10] = 'xyz.zom/';
 */
$CFG->safeurls[0] = 'www.youtube.com/embed/';
$CFG->safeurls[1] = 'player.vimeo.com/video/';
$CFG->safeurls[2] = 'www.ustream.tv/';
$CFG->safeurls[3] = 'www.schooltube.com/';
$CFG->safeurls[4] = 'archive.org/';
$CFG->safeurls[5] = 'www.blogtv.com/';
$CFG->safeurls[6] = 'uk.video.yahoo.com/';
$CFG->safeurls[7] = 'www.teachertube.com/';
$CFG->safeurls[8] = 'sciencestage.com/';
$CFG->safeurls[9] = 'www.flickr.com/';


/** LINK TYPES **/
// WARNING: Only edit these names if you have also edited them in the database linktype table.
// The two must match or the Evidence Hub code will not work properly!
$CFG->LINK_SOLUTION_ISSUE = 'addresses';
$CFG->LINK_CLAIM_ISSUE = 'responds to';
$CFG->LINK_ISSUE_CHALLENGE = 'is related to';
$CFG->LINK_EVIDENCE_SOLCLAIM_PRO = 'supports';
$CFG->LINK_EVIDENCE_SOLCLAIM_CON = 'challenges';
$CFG->LINK_ORGP_ISSUE = 'addresses';
$CFG->LINK_ORGP_CHALLENGE = 'addresses';
$CFG->LINK_ORGP_CLAIM = 'claims';
$CFG->LINK_ORGP_SOLUTION = 'specifies';
$CFG->LINK_ORGP_EVIDENCE = 'specifies';
$CFG->LINK_ORGP_ORGP = 'partnered with';
$CFG->LINK_ORG_PROJECT = 'manages';
$CFG->LINK_COMMENT_NODE = 'is related to';
$CFG->LINK_NODE_THEME = 'has main theme';
$CFG->LINK_RESOURCE_NODE = 'is related to';
$CFG->LINK_NODE_SEE_ALSO = 'see also';
$CFG->LINK_COMMENT_BUILT_FROM = 'built from';

/**
 * DEFAULT NODETYPE (role) GROUP IDS
 *
 * As found in the database NodeTypeGroup table.
 * You will be given these ids when running adddefaultdata.php as part of your install process.
 * If you are upgrading check the values for these in the NodeTypeGroup table in your database.
 */
$CFG->defaultRoleGroupID = "";
$CFG->systemRoleGroupID = "";
$CFG->evidenceRoleGroupID = "";
$CFG->resourceRoleGroupID = "";

/** SPAM ALERT **/
// Do you want to use Spam reporting in the Hub? (true/false)
// If this is set to 'true' you must also complete the SPAM_ALERT_RECIPIENT below.
$CFG->SPAM_ALERT_ON = false;
$CFG->SPAM_ALERT_RECIPIENT = "email address of person to receive spam reports";


/** USE EXTERNAL SIGN ON **/
$CFG->SOCIAL_SIGNON_ON = false;

/**
 * 1. Go to https://developer.apps.yahoo.com/dashboard/createKey.html and create a project.
 * 2. Fill out any required fields such as the Application name and description.
 * 3. Set the 'Applcation Type' to be 'Web-based'.
 * 4. Set the 'Home Page URL' to be you hub url
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 5. Int 'Access Scope' select 'This app requires access to private user data'.
 * 	  A section will expand out. Enter the Application Domain as in 4. above.
 * 6. In 'Select APIs for private user data access:', select 'Social Directory' and leave it as 'Read Public'.
 * 7. Once you have created the project, copy and paste the 'Consumer Key' as the $CFG-SOCIAL_SIGNON_YAHOO_ID
 *    and the 'Consumer Secret' as the $CFG->SOCIAL_SIGNON_YAHOO_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_YAHOO_ON = true.
 */
$CFG->SOCIAL_SIGNON_YAHOO_ON = false;
$CFG->SOCIAL_SIGNON_YAHOO_ID = "";
$CFG->SOCIAL_SIGNON_YAHOO_SECRET = "";

/**
 * 1. Go to https://code.google.com/apis/console/ and create a new project, if you don't have one.
 * 2. Fill out any required fields such as the name and description.
 * 3. Click on "Create client ID..."/"Create another client ID...". This open a popup
 * 4. Make sure 'Application Type' has 'Web Application' selected.
 * 5. In the section 'Your site or hostname' fill in your hub url
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 6. Then select '(more options)'.
 * 7. In the section 'Authorized Redirect URIs' you need to add a callback URL for your application:
 *	  The URL should start with the URL you have entered into $CFG->homeAddress
 *    followed by 'core/lib/hybridauth/?hauth.done=Google'
 * 	  e.g. https://test.evidence-hub.net/core/lib/hybridauth/?hauth.done=Google
 * 	  Then press 'Create Client ID'
 * 8. Once you have done this, copy and paste the 'Client ID' as the $CFG-SOCIAL_SIGNON_GOOGLE_ID
 *    and the 'Client Secret' as the $CFG->SOCIAL_SIGNON_GOOGLE_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_GOOGLE_ON = true.
*/
$CFG->SOCIAL_SIGNON_GOOGLE_ON = false;
$CFG->SOCIAL_SIGNON_GOOGLE_ID = "";
$CFG->SOCIAL_SIGNON_GOOGLE_SECRET = "";

/**
 * 1. Go to https://www.facebook.com/developers/ and create a new application.
 * 2. Fill out any required fields such as the application name and description.
 * 3. Make sure you have 'Sandbox Mode' set to Disabled once your site is live, or only your developer Facebook user will be able to use the Social Sign On.
 * 4. Select 'Website with Facebook Login' and add your hub url into the 'Site URL' field.
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 5. Once you have registered, copy and paste the 'App ID' as the $CFG->SOCIAL_SIGNON_FACEBOOK_ID
 *    and the 'App Secret' as the $CFG->SOCIAL_SIGNON_FACEBOOK_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_FACEBOOK_ON = true.
 */
$CFG->SOCIAL_SIGNON_FACEBOOK_ON = false;
$CFG->SOCIAL_SIGNON_FACEBOOK_ID = "";
$CFG->SOCIAL_SIGNON_FACEBOOK_SECRET = "";

/**
 * 1. Go to https://code.google.com/apis/console/ and create a new application
 * 2. Fill out any required fields such as the application name and description.
 * 3. Put your website domain in the Application Website and Application Callback URL fields.
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 4. Set the Default Access Type to Read, Write, & Direct Messages.
 * 5. Tick the checkbox beside 'Allow this application to be used to Sign in with Twitter'
 * 6. Once you have registered, copy and paste the 'Consumer key' as the $CFG->SOCIAL_SIGNON_TWITTER_ID
 *    and the 'Consumer secret' as the $CFG->SOCIAL_SIGNON_TWITTER_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_YAHOO_ON = true.
 */
$CFG->SOCIAL_SIGNON_TWITTER_ON = false;
$CFG->SOCIAL_SIGNON_TWITTER_ID = "";
$CFG->SOCIAL_SIGNON_TWITTER_SECRET = "";

/**
 * 1. Go to https://www.linkedin.com/secure/developer and create a new application.
 * 2. Fill out any required fields such as the application name and description.
 * 3. Put your website domain in the Website URL field.
 *    It should match with the current domain given in $CFG->homeAddress minus the final slash.
 * 4. Set 'Live Status' to Live (if you are live).
 * 5. In the OAuth User Agreement section, select  'r_fullprofile' and 'r_emailaddress'
 * 6. Once you have registered, copy and paste the 'API Key' as the $CFG->SOCIAL_SIGNON_LINKEDIN_ID
 *    and the 'Secret Key' as the $CFG->SOCIAL_SIGNON_LINKEDIN_SECRET below
 *    and set $CFG->SOCIAL_SIGNON_LINKEDIN_ON = true.
 */
$CFG->SOCIAL_SIGNON_LINKEDIN_ON = false;
$CFG->SOCIAL_SIGNON_LINKEDIN_ID = "";
$CFG->SOCIAL_SIGNON_LINKEDIN_SECRET = "";
?>