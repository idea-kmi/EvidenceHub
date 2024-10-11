<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2010 - 2024 The Open University UK                            *
 *                                                                              *
 *  This software is freely distributed in accordance with                      *
 *  the GNU Lesser General Public (LGPL) license, version 3 or later            *
 *  as published by the Free Software Foundation.                               *
 *  For details see LGPL: http://www.fsf.org/licensing/licenses/lgpl.html       *
 *               and GPL: http://www.fsf.org/licensing/licenses/gpl-3.0.html    *
 *                                                                              *
 *  This software is provided by the copyright holders and contributors "as is" *
 *  and any express or implied warranties, including, but not limited to, the   *
 *  implied warranties of merchantability and fitness for a particular purpose  *
 *  are disclaimed. In no event shall the copyright owner or contributors be    *
 *  liable for any direct, indirect, incidental, special, exemplary, or         *
 *  consequential damages (including, but not limited to, procurement of        *
 *  substitute goods or services; loss of use, data, or profits; or business    *
 *  interruption) however caused and on any theory of liability, whether in     *
 *  contract, strict liability, or tort (including negligence or otherwise)     *
 *  arising in any way out of the use of this software, even if advised of the  *
 *  possibility of such damage.                                                 *
 *                                                                              *
 ********************************************************************************/


/**
 * languageui.php
 *
 * Michelle Bachler (KMi)
 *
 * This should eventually be broken up into separate files and become part of the internationalization of the Evidence Hub
 */

/** HEADERS **/
$LNG->HEADER_LOGO_HINT = 'Vai a '.$CFG->SITE_TITLE.' home page';
$LNG->HEADER_LOGO_ALT = $CFG->SITE_TITLE.' Logo';
$LNG->HEADER_HOME_ICON_HINT = 'Torna alla Home Page';
$LNG->HEADER_HOME_ICON_ALT = 'Icon Home';
$LNG->HEADER_OU_LOGO_HINT =  'Vai al Sito della Open University';
$LNG->HEADER_OU_LOGO_ALT =  'Logo Open University';
$LNG->HEADER_RSS_FEED_ICON_HINT = 'Ottieni un feed RSS per Evidence Hub. Nota: ogni categoria ha anche il proprio feed.';
$LNG->HEADER_RSS_FEED_ICON_ALT = 'Icona RSS';
$LNG->HEADER_VERSION_TEXT = 'Alpha';
$LNG->HEADER_USER_HOME_LINK_HINT = 'Vai alla Home Page';
$LNG->HEADER_EDIT_PROFILE_LINK_TEXT = 'Modifica Profilo';
$LNG->HEADER_EDIT_PROFILE_LINK_HINT = 'Modifica informazioni di contatto';
$LNG->HEADER_SIGN_OUT_LINK_TEXT = 'Esci';
$LNG->HEADER_SIGN_OUT_LINK_HINT = 'Esci';
$LNG->HEADER_SIGN_IN_LINK_TEXT = 'Accedi';
$LNG->HEADER_SIGN_IN_LINK_HINT = 'Accedi';
$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT = 'Registrati';
$LNG->HEADER_SIGNUP_OPEN_LINK_HINT = 'Registrati subito per accedere e aggiungere dati';
$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT = 'Registrati';
$LNG->HEADER_SIGNUP_REQUEST_LINK_HINT = 'Richiedi subito un account per accedere e aggiungere dati';
$LNG->HEADER_HELP_PAGE_LINK_TEXT = 'Aiuto';
$LNG->HEADER_HELP_PAGE_LINK_HINT = 'Vai alla pagina Aiuto';
$LNG->HEADER_ABOUT_PAGE_LINK_TEXT = 'Chi siamo';
$LNG->HEADER_ABOUT_PAGE_LINK_HINT = 'Vai alla pagina Chi siamo';
$LNG->HEADER_ADMIN_PAGE_LINK_TEXT = 'Admin';
$LNG->HEADER_ADMIN_PAGE_LINK_HINT = 'Vail alla pagina Admin';
$LNG->HEADER_SEARCH_BOX_LABEL = 'Cerca nel sito';
$LNG->HEADER_SEARCH_TAGS_ONLY_LABEL = 'Solo tags (separati dalla virgola)';
$LNG->HEADER_SEARCH_RUN_ICON_HINT = 'Cerca';
$LNG->HEADER_SEARCH_RUN_ICON_ALT = 'Cerca';
$LNG->HEADER_MY_HUB_LINK = 'il mio Hub';

/** ODD **/
$LNG->PRACTITIONER_STORY_NAME = "-";
$LNG->RESEARCHER_STORY_NAME = "-";
$LNG->RESET_INVALID_MESSAGE = 'Codice di reimpostazione della password non valido';
$LNG->POPUPS_BLOCK = 'Sembra che tu abbia bloccato le finestre popup.\n\n Modificare le impostazioni del browser per consentire a questo Evidence Hub di aprire finestre popup.';
$LNG->SIDEBAR_TITLE = "Visitati di recente";
$LNG->INDEX_ALL_DATA = 'Tutti i dati';
$LNG->ENTER_URL_FIRST = 'Devi prima inserire un URL';

/** TABS **/
//main
$LNG->TAB_HOME = 'Home';
$LNG->TAB_CHALLENGE = $LNG->CHALLENGES_NAME;
$LNG->TAB_ISSUE = $LNG->ISSUES_NAME;
$LNG->TAB_SOLUTION = $LNG->SOLUTIONS_NAME;
$LNG->TAB_CLAIM = $LNG->CLAIMS_NAME;
$LNG->TAB_EVIDENCE = $LNG->EVIDENCES_NAME;
$LNG->TAB_RESOURCE = $LNG->RESOURCES_NAME;
$LNG->TAB_ORG = $LNG->ORGS_NAME;
$LNG->TAB_PROJECT = $LNG->PROJECTS_NAME;
$LNG->TAB_USER = $LNG->USERS_NAME;
$LNG->TAB_SOCIAL = 'Social';
$LNG->TAB_COMMENT = $LNG->COMMENTS_NAME;
$LNG->TAB_NEWS = $LNG->NEWSS_NAME;

//user
$LNG->TAB_USER_HOME = 'La mia Home';
$LNG->TAB_USER_CHALLENGE = $LNG->CHALLENGES_NAME_SHORT;
$LNG->TAB_USER_ISSUE = $LNG->ISSUES_NAME_SHORT;
$LNG->TAB_USER_SOLUTION = $LNG->SOLUTIONS_NAME_SHORT;
$LNG->TAB_USER_CLAIM = $LNG->CLAIMS_NAME_SHORT;
$LNG->TAB_USER_EVIDENCE = $LNG->EVIDENCES_NAME_SHORT;
$LNG->TAB_USER_RESOURCE = $LNG->RESOURCES_NAME_SHORT;
$LNG->TAB_USER_ORG = $LNG->ORGS_NAME;
$LNG->TAB_USER_PROJECT = $LNG->PROJECTS_NAME;
$LNG->TAB_USER_CHAT = $LNG->CHATS_NAME;
$LNG->TAB_USER_COMMENT = $LNG->COMMENTS_NAME;
$LNG->TAB_USER_USED_COMMENT = 'Utilizzate '.$LNG->COMMENTS_NAME;

//inner view
$LNG->TAB_VIEW_OVERVIEW = 'Dashboard';
$LNG->TAB_VIEW_LIST = 'Lista';
$LNG->TAB_VIEW_THEME_MAP = $LNG->THEME_NAME.' Mappa';
$LNG->TAB_VIEW_GEOMAP = 'Geo-Mappa';

//explore
$LNG->VIEWS_LINEAR_TITLE = "Albero della conoscenza";
$LNG->VIEWS_LINEAR_HINT = "Fare clic per visualizzare qualsiasi albero della conoscenza per questo elemento";
$LNG->VIEWS_WIDGET_TITLE = "Dettagli";
$LNG->WIDGET = "Fare clic per visualizzare qualsiasi albero della conoscenza per questo elemento";
$LNG->VIEWS_EVIDENCE_MAP_TITLE="Grafico di rete";
$LNG->VIEWS_EVIDENCE_MAP_HINT="Fare clic per visualizzare il grafico di rete per questo elemento";
$LNG->VIEWS_ORG_MAP_TITLE="Rete organizzativa ";

/** TAB PAGES TEXT **/
$LNG->TAB_CHALLENGE_STRAPLINE = "Quali solo le ".$LNG->CHALLENGES_NAME." da affrontare per lo sviluppo dell'Agenda Metropolitana per lo Sviluppo Sostenibile?";
$LNG->TAB_ISSUE_STRAPLINE = "Quali sono le ".$LNG->ISSUES_NAME." da affrontare per lo sviluppo dell'Agenda Metropolitana Urbana per lo Sviluppo Sostenibile?";
$LNG->TAB_SOLUTION_STRAPLINE = "L'Agenda Metropolitana Urbana per lo Sviluppo Sostenibile ha bisogno delle vostre ".$LNG->SOLUTIONS_NAME;
$LNG->TAB_CLAIM_STRAPLINE = "C'è un dibattito in corso - Eccolo sintetizzato e connesso";
$LNG->TAB_EVIDENCE_STRAPLINE = 'Esplora il'.$LNG->EVIDENCES_NAME.': politiche, casi studio, ricerche e storie.';
$LNG->TAB_RESOURCE_STRAPLINE = "Nell'HUB, Pubblicazioni e Risorse web sono usate per supportare le diverse ".$LNG->EVIDENCES_NAME;
$LNG->TAB_ORG_STRAPLINE = "Benvenuti! Questi sono i ".$LNG->ORGS_NAME." registrati sul sito fino ad ora";
$LNG->TAB_PROJECT_STRAPLINE = 'Benvenuti! Questi sono i'.$LNG->PROJECTS_NAME.' registrati sul sito fino ad ota.';
$LNG->TAB_COMMENT_STRAPLINE = $LNG->COMMENTS_NAME.' fatti su Evidence Hub';
$LNG->TAB_USER_STRAPLINE = 'Benvenuti! Questi sono gli utenti registrati sul sito fino ad ora';
$LNG->TAB_COMMENT_USER_STRAPLINE = $LNG->COMMENTS_NAME.' fatto da questo utente su Evidence Hub';

/** ERROR MESSAGES */
$LNG->DATABASE_CONNECTION_ERROR = 'Impossibile connettersi al database - controllare la configurazione del server.';
$LNG->ITEM_NOT_FOUND_ERROR = 'Articolo non trovato';


/** BUTTONS AND LINK HINTS **/
$LNG->SIGN_IN_HINT = "Accedi per aggiungere contenuti all'Evidence Hub";
$LNG->SIGN_IN_FOLLOW_HINT = "Accedi per seguire questo elemento";

$LNG->Aggiungi_BUTTON = 'Aggiungi';
$LNG->FOLLOW_BUTTON_ALT = 'Segui';
$LNG->FOLLOW_OFF_BUTTON_ALT = 'Non seguire più';

$LNG->EDIT_BUTTON_TEXT = 'Modifica';
$LNG->EDIT_BUTTON_HINT_ITEM = 'Modifica questo elemento';
$LNG->EDIT_BUTTON_HINT_CHALLENGE = 'Modifica'.$LNG->CHALLENGE_NAME;
$LNG->EDIT_BUTTON_HINT_ISSUE = 'Modifica'.$LNG->ISSUE_NAME;
$LNG->EDIT_BUTTON_HINT_CLAIM = 'Modifica'.$LNG->CLAIM_NAME;
$LNG->EDIT_BUTTON_HINT_SOLUTION = 'Modifica '.$LNG->SOLUTION_NAME;
$LNG->EDIT_BUTTON_HINT_EVIDENCE = 'Modifica'.$LNG->EVIDENCE_NAME;
$LNG->EDIT_BUTTON_HINT_RESOURCE = 'Modifica '.$LNG->RESOURCE_NAME;

$LNG->DELETE_BUTTON_ALT = 'Cancella';
$LNG->DELETE_BUTTON_HINT = 'Cancella questo elemento';
$LNG->NO_DELETE_BUTTON_ALT = 'Impossibile cancellare';
$LNG->NO_DELETE_BUTTON_HINT = 'Non puoi cancellare questo elemento. Qualcuno ci si è collegato';

/** USER PAGE **/
$LNG->USER_FOLLOW_HINT = 'Sequi questo utente...';
$LNG->USER_FOLLOW_BUTTON = 'Segui';
$LNG->USER_UNFOLLOW_HINT = 'Non seguire più questo utente...';
$LNG->USER_UNFOLLOW_BUTTON = 'Non seguire più';

$LNG->USER_RSS_HINT = 'Ottieni un feed RSS per ';
$LNG->USER_RSS_BUTTON = 'Feed RSS';

/** LIST NAV **/
$LNG->LIST_NAV_PREVIOUS_HINT = 'Precedente';
$LNG->LIST_NAV_NO_PREVIOUS_HINT = 'No precedente';
$LNG->LIST_NAV_NEXT_HINT = 'Successivo';
$LNG->LIST_NAV_NO_NEXT_HINT = 'No successivo';
$LNG->LIST_NAV_NO_ITEMS = "Nessun elemento aggiunto.";
$LNG->LIST_NAV_TO = 'a';
$LNG->LIST_NAV_USER_NO_CHALLENGE = "Nessuna ".$LNG->CHALLENGES_NAME.' trovata';
$LNG->LIST_NAV_USER_NO_ORG = "Nessun ".$LNG->ORGS_NAME.' trovato';
$LNG->LIST_NAV_USER_NO_PROJECT = "Nessun ".$LNG->PROJECTS_NAME.' trovato';
$LNG->LIST_NAV_USER_NO_ISSUE = "Nessuna ".$LNG->ISSUES_NAME.' trovata';
$LNG->LIST_NAV_USER_NO_SOLUTION = "Nessuna ".$LNG->SOLUTIONS_NAME.' trovata';
$LNG->LIST_NAV_USER_NO_CLAIM = "Nessuna ".$LNG->CLAIMS_NAME.' trovata';
$LNG->LIST_NAV_USER_NO_EVIDENCE = "Nessuna ".$LNG->EVIDENCES_NAME.' trovata';
$LNG->LIST_NAV_USER_NO_RESOURCE = "Nessuna ".$LNG->RESOURCES_NAME.' trovata';
$LNG->LIST_NAV_USER_NO_COMMENT = "Nessun ".$LNG->COMMENTS_NAME.' trovato';
$LNG->LIST_NAV_USER_NO_NEWS = "Nessuna ".$LNG->NEWS_NAME.' trovata';
$LNG->LIST_NAV_USER_NO_CHAT = "Nessuna ".$LNG->CHATS_NAME.' trovata';
$LNG->LIST_NAV_NO_CHALLENGE = 'Non ci sono '.$LNG->CHALLENGES_NAME.' da mostrare';
$LNG->LIST_NAV_NO_EVIDENCE = 'Non ci sono '.$LNG->EVIDENCE_NAME.' da mostrare';
$LNG->LIST_NAV_NO_ORGS = 'Non ci sono '.$LNG->ORGS_NAME.' da mostrare';
$LNG->LIST_NAV_NO_PROJECTS = 'Non ci sono  '.$LNG->PROJECTS_NAME.' da mostrare';
$LNG->LIST_NAV_NO_RESOURCE = 'Non ci sono  '.$LNG->RESOURCES_NAME.' da mostrare';
$LNG->LIST_NAV_NO_ISSUE = 'Non ci sono  '.$LNG->ISSUES_NAME.' da mostrare';
$LNG->LIST_NAV_NO_SOLUTION = 'Non ci sono  '.$LNG->SOLUTIONS_NAME.' da mostrare';
$LNG->LIST_NAV_NO_CLAIM = 'Non ci sono '.$LNG->CLAIMS_NAME.' da mostrare';
$LNG->LIST_NAV_NO_ITEMS = 'Non ci sono  elementi da mostrare';

/** FILTERS AND SORTS **/
$LNG->FILTER_BY = 'Filtra per';
$LNG->FILTER_TYPES_ALL = 'Tutti';
$LNG->FILTER_THEMES_ALL = 'Tutti '.$LNG->THEMES_NAME;
$LNG->FILTER_THEME_LABEL = $LNG->THEME_NAME.':';
$LNG->FILTER_ALSO_SELECT_THEME = 'Seleziona anche '.$LNG->THEME_NAME;
$LNG->FILTER_COUNTRY_DEFAULT = 'Visualizzazione predefinita...';

$LNG->SORT_BY = 'Ordina per';
$LNG->SORT_ASC = 'Ascendente';
$LNG->SORT_DESC = 'Discendente';
$LNG->SORT_CREATIONDATE = 'Data di creazione';
$LNG->SORT_MODDATE = 'Data di modifica';
$LNG->SORT_TITLE = 'Titolo';
$LNG->SORT_NAME = 'Nome';
$LNG->SORT_CONNECTIONS = 'Connessioni';
$LNG->SORT_VOTES = 'Voti';
$LNG->SORT_LAST_LOGIN = 'Ultimo accesso';
$LNG->SORT_LAST_ACTIVE = 'Ultima attività';
$LNG->SORT_DATE_JOINED = 'Data di iscrizione';

/** LOADING MESSAGES **/
$LNG->LOADING_ITEMS = "Caricamente elementi";
$LNG->LOADING_MESSAGE_PRINT_NODE = "L'operazione potrebbe richiedere circa un minuto a seconda della lunghezza dell'elenco che stai visualizzando";
$LNG->LOADING_CHALLENGES = '(Loading '.$LNG->CHALLENGES_NAME.'...)';
$LNG->LOADING_ISSUES = '(Loading '.$LNG->ISSUES_NAME.'...)';
$LNG->LOADING_SOLUTIONS = '(Loading '.$LNG->SOLUTIONS_NAME.'...)';
$LNG->LOADING_CLAIMS = '(Loading '.$LNG->CLAIMS_NAME.'...)';
$LNG->LOADING_EVIDENCES = '(Loading '.$LNG->EVIDENCES_NAME.'...)';
$LNG->LOADING_RESOURCES = '(Loading '.$LNG->RESOURCES_NAME.'...)';
$LNG->LOADING_ORGS = '(Loading '.$LNG->ORGS_NAME.'...)';
$LNG->LOADING_PROJECTS = '(Loading '.$LNG->PROJECTS_NAME.'...)';
$LNG->LOADING_USERS = '(Loading '.$LNG->USERS_NAME.'...)';
$LNG->LOADING_DATA = '(Loading data...)';
$LNG->LOADING_COMMENTS = '(Loading '.$LNG->COMMENTS_NAME.'...)';
$LNG->LOADING_CHATS = '(Loading '.$LNG->CHATS_NAME.'...)';
$LNG->LOADING_NEWS = '(Loading '.$LNG->NEWS_NAME.'...)';

/** Cerca risultati PAGE **/
$LNG->SEARCH_TITLE_ERROR = 'Risultati';
$LNG->SEARCH_TITLE_TAGS = 'Risultati della ricerca per tag: ';
$LNG->SEARCH_ERROR_EMPTY = 'Devi inserire qualcosa da cercare.';
$LNG->SEARCH_TITLE = 'Cerca risultati: ';
$LNG->SEARCH_BACKTOTOP = 'Torna su';
$LNG->SEARCH_BACKTOTOP_IMG_ALT = 'su';

/** DATAMODEL HINT TEXT **/
// Evidence
$LNG->DATAMODEL_evidenceToResource = 'Selezione/aggiungi una '.$LNG->RESOURCE_NAME.' da associare a questa'.$LNG->EVIDENCE_NAME;
$LNG->DATAMODEL_evidenceToSolution = 'Selezione/aggiungi una '.$LNG->SOLUTION_NAME.' supportata/sfidata da questa '.$LNG->EVIDENCE_NAME.'';
$LNG->DATAMODEL_evidenceToClaim = 'Selezione/aggiungi una '.$LNG->CLAIM_NAME.' supportata/sfidata da questa '.$LNG->EVIDENCE_NAME.'';
$LNG->DATAMODEL_evidenceToOrg = 'Selezione/aggiungi un  '.$LNG->ORG_NAME.' associato al questa '.$LNG->EVIDENCE_NAME;
$LNG->DATAMODEL_evidenceToProject = 'Selezione/aggiunti un '.$LNG->PROJECT_NAME.' da associare al questa '.$LNG->EVIDENCE_NAME;
//Resource
$LNG->DATAMODEL_resourceToOrg = 'Selezione/aggiungi un '.$LNG->ORG_NAME.' connesso a questa'.$LNG->RESOURCE_NAME;
$LNG->DATAMODEL_resourceToProject = 'Selezione/aggiungi un '.$LNG->PROJECT_NAME.' connesso al questa '.$LNG->RESOURCE_NAME;
$LNG->DATAMODEL_resourceToChallenge = 'Seleziona '.$LNG->CHALLENGE_NAME.' connesso a questa '.$LNG->RESOURCE_NAME;
$LNG->DATAMODEL_resourceToIssue = 'Seleziona una '.$LNG->ISSUE_NAME.' connessa a questa'.$LNG->RESOURCE_NAME;
$LNG->DATAMODEL_resourceToEvidence = 'Seleziona/aggiungi una '.$LNG->EVIDENCE_NAME.' connessa alla presente '.$LNG->RESOURCE_NAME;
//org
$LNG->DATAMODEL_orgToIssue = 'Seleziona/aggiungi una'.$LNG->ISSUE_NAME.' indirizzata a '.$LNG->ORG_NAME;
$LNG->DATAMODEL_orgToClaim = 'Seleziona/aggiungi una '.$LNG->CLAIM_NAME.' sostenuta da '.$LNG->ORG_NAME;
$LNG->DATAMODEL_orgToSolution = 'Seleziona/aggiungi una '.$LNG->SOLUTION_NAME.' promossa dalla seguente '.$LNG->ORG_NAME.'';
$LNG->DATAMODEL_orgToChallenge = 'Seleziona una'.$LNG->CHALLENGE_NAME.'indirizzata a '.$LNG->ORG_NAME;
$LNG->DATAMODEL_orgToProject = 'Seleziona/aggiungi un '.$LNG->PROJECT_NAME.' gestito dal seguente '.$LNG->ORG_NAME;
$LNG->DATAMODEL_orgToOrg = 'Seleziona/aggiungi un '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.' che collabora con il seguente '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME;
$LNG->DATAMODEL_orgToResource = 'Seleziona/aggiungi una'.$LNG->RESOURCE_NAME.' da associare al presente '.$LNG->ORG_NAME;
$LNG->DATAMODEL_orgToEvidence = 'Seleziona/aggiungi una '.$LNG->EVIDENCE_NAME.' da associare al presente '.$LNG->ORG_NAME;
$LNG->DATAMODEL_projectToOrg = 'Seleziona/aggiungi un '.$LNG->ORG_NAME.' che gestisce questo '.$LNG->PROJECT_NAME;
//project
$LNG->DATAMODEL_projectToIssue = 'Seleziona/aggiungi una '.$LNG->ISSUE_NAME.' affrontata dal seguente '.$LNG->PROJECT_NAME;
$LNG->DATAMODEL_projectToClaim = 'Seleziona/aggiungi una '.$LNG->CLAIM_NAME.' sostenuta '.$LNG->PROJECT_NAME;
$LNG->DATAMODEL_projectToSolution = 'Seleziona/aggiungi una '.$LNG->SOLUTION_NAME.' promossa dal presente '.$LNG->PROJECT_NAME.' ';
$LNG->DATAMODEL_projectToChallenge = 'Seleziona una '.$LNG->CHALLENGE_NAME.' affrontata dalla presente '.$LNG->PROJECT_NAME;
$LNG->DATAMODEL_projectToResource = 'Seleziona/aggiungi una '.$LNG->RESOURCE_NAME.' da associare al presente '.$LNG->PROJECT_NAME;
$LNG->DATAMODEL_projectToEvidence = 'Seleziona/aggiungi una '.$LNG->EVIDENCE_NAME.' da associare al presente '.$LNG->PROJECT_NAME;
$LNG->DATAMODEL_projectToOrg = 'Seleziona/aggiungi una '.$LNG->ORG_NAME.' che gestisce questo '.$LNG->PROJECT_NAME;
//issue
$LNG->DATAMODEL_issueToClaim = 'Seleziona/aggiungi una'.$LNG->CLAIM_NAME.' che risponde a questa '.$LNG->ISSUE_NAME;
$LNG->DATAMODEL_issueToSolution = 'Seleziona/aggiungi una'.$LNG->SOLUTION_NAME.' che affronta questa '.$LNG->ISSUE_NAME;
$LNG->DATAMODEL_issueToOrg = 'Seleziona/aggiungi un '.$LNG->ORG_NAME.' che affronta questa '.$LNG->ISSUE_NAME;
$LNG->DATAMODEL_issueToProject = 'Seleziona/aggiungi un'.$LNG->PROJECT_NAME.' che affronta questa '.$LNG->ISSUE_NAME;
$LNG->DATAMODEL_issueToChallenge = 'Seleziona/aggiungi una'.$LNG->CHALLENGE_NAME.' che affronti questa'.$LNG->ISSUE_NAME.' legata a';
$LNG->DATAMODEL_issueToResource = 'Seleziona/aggiungi una '.$LNG->RESOURCE_NAME.' da associare alla presente '.$LNG->ISSUE_NAME;
//Claim
$LNG->DATAMODEL_claimToOrg = 'Seleziona/aggiungi un '.$LNG->ORG_NAME.' che sostenga questa '.$LNG->CLAIM_NAME;
$LNG->DATAMODEL_claimToProject = 'Seleziona/aggiungi un '.$LNG->PROJECT_NAME.' che sostenga questa '.$LNG->CLAIM_NAME;
$LNG->DATAMODEL_claimToIssue = 'Seleziona/aggiungi un '.$LNG->ISSUE_NAME.' a cui la presente '.$LNG->CLAIM_NAME.' risponde';
$LNG->DATAMODEL_claimToChallenge = 'Seleziona una '.$LNG->CHALLENGE_NAME.' a cui la presente'.$LNG->CLAIM_NAME.' risponde';
//Challenge
$LNG->DATAMODEL_challengeToIssue = 'Seleziona/aggiungi una sotto- '.$LNG->ISSUE_NAME.' a questa'.$LNG->CHALLENGE_NAME;
$LNG->DATAMODEL_challengeToResource = 'Seleziona/aggiungi una '.$LNG->RESOURCE_NAME.' da associare a questa '.$LNG->CHALLENGE_NAME;
$LNG->DATAMODEL_challengeToOrg = 'Seleziona/aggiungi una'.$LNG->ORG_NAME.' che affronta questa '.$LNG->CHALLENGE_NAME;
$LNG->DATAMODEL_challengeToProject = 'Seleziona/aggiungi un '.$LNG->PROJECT_NAME.' che affronta questa  '.$LNG->CHALLENGE_NAME;
//Solution
$LNG->DATAMODEL_solutionToOrg = 'Seleziona/aggiungi un '.$LNG->ORG_NAME.' che promuove questa '.$LNG->SOLUTION_NAME;
$LNG->DATAMODEL_solutionToProject = 'Seleziona/aggiungi un '.$LNG->PROJECT_NAME.' che promuove questa '.$LNG->SOLUTION_NAME;
$LNG->DATAMODEL_solutionToIssue = 'Seleziona/aggiungi una '.$LNG->ISSUE_NAME.' affrontata da questa '.$LNG->SOLUTION_NAME.'';
$LNG->DATAMODEL_solutionToChallenge = 'Seleziona una '.$LNG->CHALLENGE_NAME.' affrontata da questa '.$LNG->SOLUTION_NAME.'';

/** EXPLORE SECTION TITLES **/
//Challenge
$LNG->EXPLORE_challengeToIssue = $LNG->ISSUES_NAME;
$LNG->EXPLORE_challengeToResource = $LNG->RESOURCES_NAME.' associate a questa '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_challengeToOrg = $LNG->ORGS_NAME.' che affrontano questa '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_challengeToProject = $LNG->PROJECTS_NAME.'che affrontano questa '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_challengeToTheme = $LNG->THEMES_NAME.' collegati a questa '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_challengeToComment = $LNG->COMMENTS_NAME.' su questa '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_challengeToFollower = $LNG->FOLLOWERS_NAME.' di questa '.$LNG->CHALLENGE_NAME;
//Issue
$LNG->EXPLORE_issueToSolution = $LNG->SOLUTIONS_NAME;
$LNG->EXPLORE_issueToClaim = $LNG->CLAIMS_NAME;
$LNG->EXPLORE_issueToChallenge = $LNG->CHALLENGES_NAME;
$LNG->EXPLORE_issueToOrg = $LNG->ORGS_NAME.' che affrontano questa '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_issueToProject = $LNG->PROJECTS_NAME.' che affrontano questa '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_issueToResource = $LNG->RESOURCES_NAME.' collegate a questa '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_issueToTheme = $LNG->THEMES_NAME.' assegnati a questa'.$LNG->ISSUE_NAME;
$LNG->EXPLORE_issueToComment = $LNG->COMMENTS_NAME.' su questa '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_issueToFollower = $LNG->FOLLOWERS_NAME.' di questa '.$LNG->ISSUE_NAME;
//Claim
$LNG->EXPLORE_claimToEvidenceSupport = $LNG->EVIDENCE_NAME.' a favore';
$LNG->EXPLORE_claimToEvidenceCounter = $LNG->EVIDENCE_NAME.' contro';
$LNG->EXPLORE_claimToIssue = $LNG->ISSUES_NAME;
$LNG->EXPLORE_claimToOrg = $LNG->ORGS_NAME.' che supportano questa '.$LNG->CLAIM_NAME;
$LNG->EXPLORE_claimToProject = $LNG->PROJECTS_NAME.' che supportano questa '.$LNG->CLAIM_NAME;
$LNG->EXPLORE_claimToTheme = $LNG->THEMES_NAME.' assegnati a questa '.$LNG->CLAIM_NAME;
$LNG->EXPLORE_claimToComment = $LNG->COMMENTS_NAME.' su questa '.$LNG->CLAIM_NAME;
$LNG->EXPLORE_claimToFollower = $LNG->FOLLOWERS_NAME.' di questa '.$LNG->CLAIM_NAME;
//Solution
$LNG->EXPLORE_solutionToEvidenceSupport = 'a favore '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_solutionToEvidenceCounter = 'contro '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_solutionToIssue = $LNG->ISSUES_NAME;
$LNG->EXPLORE_solutionToOrg = $LNG->ORGS_NAME.' che supportano questa '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_solutionToProject = $LNG->PROJECTS_NAME.' che supportano questa '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_solutionToTheme = $LNG->THEMES_NAME.' assegnati a questa '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_solutionToComment = $LNG->COMMENTS_NAME.' su questa '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_solutionToFollower = $LNG->FOLLOWERS_NAME.' di questa '.$LNG->SOLUTION_NAME;
//org
$LNG->EXPLORE_orgToProject = $LNG->PROJECTS_NAME_SHORT.' gestiti da questo '.$LNG->ORG_NAME_SHORT;
$LNG->EXPLORE_orgToOrg = 'Partner di questo '.$LNG->ORG_NAME_SHORT;
$LNG->EXPLORE_orgToChallenge = $LNG->CHALLENGES_NAME.' affrontate da questi '.$LNG->ORG_NAME;
$LNG->EXPLORE_orgToIssue = $LNG->ISSUE_NAME.'affrontata da questo '.$LNG->ORG_NAME;
$LNG->EXPLORE_orgToSolution = $LNG->SOLUTIONS_NAME.' specificate da questo'.$LNG->ORG_NAME;
$LNG->EXPLORE_orgToClaim = $LNG->CLAIMS_NAME.' affermate da questo '.$LNG->ORG_NAME;
$LNG->EXPLORE_orgToEvidence = $LNG->EVIDENCES_NAME.' specificate da questo '.$LNG->ORG_NAME;
$LNG->EXPLORE_orgToResource = $LNG->RESOURCES_NAME.' associate a questo'.$LNG->ORG_NAME;
$LNG->EXPLORE_orgToTheme = $LNG->THEMES_NAME.' assegnati a questo '.$LNG->ORG_NAME;
$LNG->EXPLORE_orgToComment = $LNG->COMMENTS_NAME.' fatti da questo '.$LNG->ORG_NAME;
$LNG->EXPLORE_orgToFollower = $LNG->FOLLOWERS_NAME.' di questo '.$LNG->ORG_NAME;
//project
$LNG->EXPLORE_projectToOrg = 'Partner di questo '.$LNG->PROJECT_NAME_SHORT;
$LNG->EXPLORE_projectToManager = $LNG->ORGS_NAME_SHORT.' che gestiscono questo '.$LNG->PROJECT_NAME_SHORT;
$LNG->EXPLORE_projectToChallenge = $LNG->CHALLENGES_NAME.' affrontate da questo '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_projectToIssue = $LNG->ISSUES_NAME.' affrontate da questo '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_projectToSolution = $LNG->SOLUTIONS_NAME.' specificate da questo '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_projectToClaim = $LNG->CLAIMS_NAME.' fatta da questo '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_projectToEvidence = $LNG->EVIDENCES_NAME.' specificate da questo '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_projectToResource = $LNG->RESOURCES_NAME.' associate a questo '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_projectToTheme = $LNG->THEMES_NAME.' assegnati a questo '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_projectToComment = $LNG->COMMENTS_NAME.' fatti da questo '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_projectToFollower = $LNG->FOLLOWERS_NAME.' di questo '.$LNG->PROJECT_NAME;
//Evidence
$LNG->EXPLORE_evidenceToSolution = $LNG->SOLUTIONS_NAME;
$LNG->EXPLORE_evidenceToClaim = $LNG->CLAIMS_NAME;
$LNG->EXPLORE_evidenceToOrg = $LNG->ORGS_NAME.' specificate da questa '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_evidenceToProject = $LNG->PROJECTS_NAME.' che specificano questa '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_evidenceToResource = $LNG->RESOURCES_NAME;
$LNG->EXPLORE_evidenceToTheme = $LNG->THEMES_NAME.' assegnati a questa '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_evidenceToComment = $LNG->COMMENTS_NAME.' su questa '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_evidenceToFollower = $LNG->FOLLOWERS_NAME.' di questa '.$LNG->EVIDENCE_NAME;
//Resource
$LNG->EXPLORE_resourceToChallenge = $LNG->CHALLENGES_NAME.' collegate a questa '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_resourceToIssue = $LNG->ISSUES_NAME;
$LNG->EXPLORE_resourceToEvidence = $LNG->EVIDENCES_NAME.' che usano questa '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_resourceToOrg = $LNG->ORGS_NAME.' collegati a questa '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_resourceToProject = $LNG->PROJECTS_NAME.' collegati a questa '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_resourceToTheme = $LNG->THEMES_NAME.' assegnati a questa '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_resourceToComment = $LNG->COMMENTS_NAME.' su questa '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_resourceToFollower = $LNG->FOLLOWERS_NAME.' di questa '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_resourceToResourceShort = 'Collegata a '.$LNG->RESOURCES_NAME;
$LNG->EXPLORE_resourceToResource = 'Altra '.$LNG->RESOURCES_NAME.' dallo stesso sito';
//Theme
$LNG->EXPLORE_themeToChallenge = $LNG->CHALLENGES_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToIssue = $LNG->ISSUES_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToSolution = $LNG->SOLUTIONS_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToClaim = $LNG->CLAIMS_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToEvidence = $LNG->EVIDENCES_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToResource = $LNG->RESOURCES_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToOrg = $LNG->ORGS_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToProject = $LNG->PROJECTS_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToComment = $LNG->COMMENTS_NAME.' su questo '.$LNG->THEME_NAME;
$LNG->EXPLORE_themeToFollower = $LNG->FOLLOWERS_NAME.' di questo '.$LNG->THEME_NAME;

/** EXPLORE BUTTONS,LINKS AND HINTS **/
$LNG->EXPLORE_PRINT_BUTTON_ALT = "Stampa questo elemento";
$LNG->EXPLORE_PRINT_BUTTON_HINT = "Stampa questo elemento";

$LNG->EXPLORE_COMMENT_HINT_STUB = 'Aggiungi un'.$LNG->COMMENT_NAME.'';
$LNG->EXPLORE_COMMENT_HINT_CHALLENGE = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_COMMENT_HINT_ISSUE = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_COMMENT_HINT_SOLUTION = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_COMMENT_HINT_CLAIM = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->CLAIM_NAME;
$LNG->EXPLORE_COMMENT_HINT_EVIDENCE = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_COMMENT_HINT_RESOURCE = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_COMMENT_HINT_ORG = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->ORG_NAME;
$LNG->EXPLORE_COMMENT_HINT_PROJECT = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_COMMENT_HINT_THEME = $LNG->EXPLORE_COMMENT_HINT_STUB.' '.$LNG->THEME_NAME;

$LNG->EXPLORE_THEME_HINT_STUB = 'Aggiungi un '.$LNG->THEME_NAME.'';
$LNG->EXPLORE_THEME_HINT_CHALLENGE = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->CHALLENGE_NAME;
$LNG->EXPLORE_THEME_HINT_ISSUE = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->ISSUE_NAME;
$LNG->EXPLORE_THEME_HINT_SOLUTION = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->SOLUTION_NAME;
$LNG->EXPLORE_THEME_HINT_CLAIM = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->CLAIM_NAME;
$LNG->EXPLORE_THEME_HINT_EVIDENCE = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_THEME_HINT_RESOURCE = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->RESOURCE_NAME;
$LNG->EXPLORE_THEME_HINT_ORG = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->ORG_NAME;
$LNG->EXPLORE_THEME_HINT_PROJECT = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->PROJECT_NAME;
$LNG->EXPLORE_THEME_HINT_ORGPROJECT = $LNG->EXPLORE_THEME_HINT_STUB.' '.$LNG->ORG_NAME.' or '.$LNG->PROJECT_NAME;

$LNG->EXPLORE_BACKTOTOP = 'Torna su';
$LNG->EXPLORE_BACKTOTOP_IMG_ALT = 'su';

$LNG->EXPLORE_SUPPORTING_EVIDENCE = 'a favore'.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_COUNTER_EVIDENCE = 'contro '.$LNG->EVIDENCE_NAME;
$LNG->EXPLORE_ISSUES_AddressED = $LNG->ISSUES_NAME.' affrontata';
$LNG->EXPLORE_CHALLENGES_AddressED = $LNG->CHALLENGES_NAME.' affrontata';
$LNG->EXPLORE_ORG_PROPOSING = $LNG->ORGS_NAME.' proponent';
$LNG->EXPLORE_PROJECTS_PROPOSING = $LNG->PROJECTS_NAME.' proponente';
$LNG->EXPLORE_PROJECTS_MANAGED = $LNG->PROJECTS_NAME.' gestito';
$LNG->EXPLORE_PARTNERS = 'Partner';
$LNG->EXPLORE_SOLUTIONS_SPECIFIED = $LNG->SOLUTIONS_NAME.' specificata';
$LNG->EXPLORE_CLAIMS_MADE = $LNG->CLAIMS_NAME.' fatta';
$LNG->EXPLORE_EVIDENCE_SPECIFIED = $LNG->EVIDENCES_NAME.' specificata';
$LNG->EXPLORE_MANAGING_ORGS = $LNG->ORGS_NAME.' che gestisce';

/** OVERVIEW TITLES **/
//Challenge
$LNG->OVERVIEW_CHALLENGE_MOSTRECENT_TITLE = $LNG->CHALLENGES_NAME.' più recenti';
$LNG->OVERVIEW_CHALLENGE_MOSTCONNECTED_TITLE = $LNG->CHALLENGES_NAME.' più connesse';
$LNG->OVERVIEW_CHALLENGE_MOSTVOTED_TITLE = $LNG->CHALLENGES_NAME.' più votate';
$LNG->OVERVIEW_CHALLENGE_POPULARTHEMES_TITLE = $LNG->THEMES_NAME.' più popolari per '.$LNG->CHALLENGES_NAME;
//Issue
$LNG->OVERVIEW_ISSUE_MOSTRECENT_TITLE = $LNG->ISSUES_NAME.' più recenti';
$LNG->OVERVIEW_ISSUE_MOSTCONNECTED_TITLE = $LNG->ISSUES_NAME.' più connesse';
$LNG->OVERVIEW_ISSUE_MOSTVOTED_TITLE = $LNG->ISSUES_NAME.' più votate';
$LNG->OVERVIEW_ISSUE_POPULARTHEMES_TITLE = $LNG->THEMES_NAME.' più popolari per '.$LNG->ISSUES_NAME;
//Claim
$LNG->OVERVIEW_CLAIM_MOSTRECENT_TITLE = 'più recenti '.$LNG->CLAIMS_NAME;
$LNG->OVERVIEW_CLAIM_MOSTCONNECTED_TITLE = 'più connesse '.$LNG->CLAIMS_NAME;
$LNG->OVERVIEW_CLAIM_MOSTVOTED_TITLE = 'più votate su '.$LNG->CLAIMS_NAME;
$LNG->OVERVIEW_CLAIM_POPULARTHEMES_TITLE = 'più popolari '.$LNG->THEMES_NAME.' per '.$LNG->CLAIMS_NAME;
//Solution
$LNG->OVERVIEW_SOLUTION_MOSTRECENT_TITLE = $LNG->SOLUTIONS_NAME.' più recenti';
$LNG->OVERVIEW_SOLUTION_MOSTCONNECTED_TITLE = $LNG->SOLUTIONS_NAME.' più connesse' ;
$LNG->OVERVIEW_SOLUTION_MOSTVOTED_TITLE = $LNG->SOLUTIONS_NAME.' più votate';
$LNG->OVERVIEW_SOLUTION_POPULARTHEMES_TITLE = $LNG->THEMES_NAME.' più votate per '.$LNG->SOLUTIONS_NAME;
//Evidence
$LNG->OVERVIEW_EVIDENCE_MOSTRECENT_TITLE = $LNG->EVIDENCES_NAME.' più recenti';
$LNG->OVERVIEW_EVIDENCE_MOSTCONNECTED_TITLE = $LNG->EVIDENCES_NAME.' più connesse';
$LNG->OVERVIEW_EVIDENCE_MOSTVOTED_TITLE = $LNG->EVIDENCES_NAME.' più votate';
$LNG->OVERVIEW_EVIDENCE_POPULARTHEMES_TITLE = $LNG->THEMES_NAME.' più votati nella '.$LNG->EVIDENCES_NAME;
//Resource
$LNG->OVERVIEW_RESOURCE_MOSTRECENT_TITLE = $LNG->RESOURCES_NAME.' più recenti';
$LNG->OVERVIEW_RESOURCE_MOSTCONNECTED_TITLE = $LNG->RESOURCES_NAME.' più connesse';
$LNG->OVERVIEW_RESOURCE_POPULARTHEMES_TITLE = $LNG->THEMES_NAME.' più votati per '.$LNG->RESOURCES_NAME;
//Org
$LNG->OVERVIEW_ORG_MOSTRECENT_TITLE = $LNG->ORGS_NAME_SHORT.' più recenti';
$LNG->OVERVIEW_ORG_MOSTCONNECTED_TITLE = $LNG->ORGS_NAME_SHORT.' più connessi';
$LNG->OVERVIEW_ORG_POPULARTHEMES_TITLE = $LNG->THEMES_NAME.' più popolari per '.$LNG->ORGS_NAME_SHORT;
$LNG->OVERVIEW_ORG_COUNTRIES_TITLE = $LNG->ORG_NAME_SHORT.' Paesi';
$LNG->OVERVIEW_ORG_COUNTRIES_HINT = 'clicca per esplorare tutti i '.$LNG->ORGS_NAME_SHORT;
//Project
$LNG->OVERVIEW_PROJECT_MOSTRECENT_TITLE = $LNG->PROJECTS_NAME_SHORT.' più recenti';
$LNG->OVERVIEW_PROJECT_MOSTCONNECTED_TITLE = $LNG->PROJECTS_NAME_SHORT.' più connessi';
$LNG->OVERVIEW_PROJECT_POPULARTHEMES_TITLE = $LNG->THEMES_NAME.' più popolari per '.$LNG->PROJECTS_NAME_SHORT;
$LNG->OVERVIEW_PROJECT_COUNTRIES_TITLE = $LNG->PROJECT_NAME_SHORT.' Paesi';
$LNG->OVERVIEW_PROJECT_COUNTRIES_HINT = 'clicca per esplorare tutti i '.$LNG->PROJECTS_NAME_SHORT;
//User
$LNG->OVERVIEW_USER_MOSTRECENT_TITLE = $LNG->USERS_NAME.' più recenti';
$LNG->OVERVIEW_USER_MOSTFOLLOWED_TITLE = $LNG->USERS_NAME.' più seguiti';
$LNG->OVERVIEW_USER_MOSTACTIVE_TITLE = $LNG->USERS_NAME." più attivi nell'ultimo mese";
$LNG->OVERVIEW_USER_COUNTRIES_TITLE = $LNG->USER_NAME.' Paesi';
$LNG->OVERVIEW_USER_COUNTRIES_HINT = 'clicca per esplorare tutti gli '.$LNG->USERS_NAME;
//Buttons
$LNG->OVERVIEW_BUTTON_EXPLOREALL = 'Esplora';
$LNG->OVERVIEW_BUTTON_VIEWONMAP = 'Visualizza la mappa';

/** LIST HOME BUTTON HINTS **/
$LNG->CHALLENGE_HOME_LIST_BUTTON_HINT = 'clicca per andare alla lista delle '.$LNG->CHALLENGES_NAME;
$LNG->ISSUE_HOME_LIST_BUTTON_HINT = 'clicca per andare alla lista delle '.$LNG->ISSUES_NAME;
$LNG->CLAIM_HOME_LIST_BUTTON_HINT = 'clicca per andare alla lista delle '.$LNG->CLAIMS_NAME;
$LNG->SOLUTION_HOME_LIST_BUTTON_HINT = 'clicca per andare alla lista delle '.$LNG->SOLUTIONS_NAME;
$LNG->EVIDENCE_HOME_LIST_BUTTON_HINT = 'clicca per andare alla lista delle '.$LNG->EVIDENCES_NAME;
$LNG->RESOURCE_HOME_LIST_BUTTON_HINT = 'clicca per andare alla lista delle '.$LNG->RESOURCES_NAME;
$LNG->ORG_HOME_LIST_BUTTON_HINT = 'clicca per andare alla lista dei '.$LNG->ORGS_NAME;
$LNG->PROJECT_HOME_LIST_BUTTON_HINT = 'clicca per andare alla lista dei'.$LNG->PROJECTS_NAME;
$LNG->HOME_PAGE_BUTTON_HINT = "clicca per andare alla Home Page";

$LNG->HOME_ADDITIONAL_INFO_TOGGLE_HINT = 'clicca per vedere/nascondere altre informazioni';

$LNG->NAV_FILTER_ORG_HINT = 'clicca per filtrare i '.$LNG->ORG_NAME.'. Clicca ancora per rimuovere il filtro.';
$LNG->NAV_FILTER_PROJECT_HINT = 'clicca per filtrare i '.$LNG->PROJECT_NAME.'. Clicca ancora per rimuovere il filtro.';

/** FORM LABELS, BUTTONS AND TEXT **/
$LNG->MAILCHIMP_NEWSLETTER_FORM_REGISTER_MESSAGE = "Spunta per ricevere la nostra newsletter";
$LNG->MAILCHIMP_NEWSLETTER_FORM_PROFILE_MESSAGE = "Attiva/disattiva la ricezione della nostra newsletter";
$LNG->MAILCHIMP_NEWSLETTER_FORM_FURTHER_INFO = "Scopri di più sulla nostra newsletter";
$LNG->MAILCHIMP_NEWSLETTER_FORM_MESSAGE = "Usiamo MailChimp per le nostre newsletter. Se ti iscrivi, tieni presente che il tuo indirizzo email sarà condiviso con il nostro account MailChimp.";
$LNG->MAILCHIMP_NEWSLETTER_FORM_SUBSCRIPTION_SUCCESS = "Iscrizione alla newsletter avvenuta con successo - cerca l'email di conferma!";
$LNG->MAILCHIMP_NEWSLETTER_FORM_SUBSCRIPTION_FAILED = "Tentativo fallito di iscriverti alla Newsletter (vedi sopra per i dettagli)";
$LNG->MAILCHIMP_NEWSLETTER_FORM_UNSUBSCRIPTION_FAILED = "Tentativo fallito di cancellarti dalla Newsletter (vedi sopra per i dettagli)";
$LNG->MAILCHIMP_NEWSLETTER_FORM_SUBSCRIPTION_FAILED_NEW_EMAIL = "Tentativo fallito di iscriverti alla Newsletter (vedi sopra per i dettagli) con il tuo nuovo indirizzo email";
$LNG->MAILCHIMP_NEWSLETTER_FORM_UNSUBSCRIPTION_FAILED_OLD_EMAIL = "Tentativo fallito di cancellarti dalla Newsletter (vedi sopra per i dettagli) dal tuo precedente indirizzo email";
$LNG->MAILCHIMP_NEWSLETTER_FORM_EDIT_NAME_FAILED = "Tentativo fallito di cambiare il tuo nome sulla Newsletter (vedi sopra per i dettagli)";

$LNG->CONDITIONS_REGISTER_FORM_TITLE = "Termini e condizioni di utilizzo";
$LNG->CONDITIONS_REGISTER_FORM_MESSAGE = 'Registrandoti come membro di questo sito accetti i Termini e le Condizioni di questo sito come scritte nel nostro <a href="'.$CFG->homeAddress.'ui/pages/conditionsofuse.php">Termini di utilizzo</a>.';
$LNG->CONDITIONS_AGREE_FORM_REGISTER_MESSAGE = "Accetto i termini e le condizioni d'uso di questo Sito";
$LNG->CONDITIONS_AGREE_FAILED_MESSAGE = "Devi accettare i termini e le condizioni d'uso di questo sito prima di poterti registrare.";

/** QUICK FORM SPECIFIC **/
$LNG->QUICKFORM_STEP1 = 'Step 1: '.$LNG->ISSUE_NAME;
$LNG->QUICKFORM_P_STEP2 = 'Step 2: '.$LNG->SOLUTION_NAME;
$LNG->QUICKFORM_R_STEP2 = 'Step 2: '.$LNG->CLAIM_NAME;
$LNG->QUICKFORM_STEP3 = 'Step 3: '.$LNG->EVIDENCE_NAME;
$LNG->QUICKFORM_STEP4 = 'Step 4: '.$LNG->RESOURCE_NAME;
$LNG->QUICKFORM_STEP5 = 'Step 5: '.$LNG->THEMES_NAME.' & Tags';
$LNG->QUICKFORM_STEP5b = '& '.$LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.'';
$LNG->QUICKFORM_OPTIONAL = '(opzionale) ';

$LNG->QUICKFORM_STEP1_HINT = 'Clicca per visualizzare la sezione '.$LNG->ISSUE_NAME.' del form';
$LNG->QUICKFORM_P_STEP2_HINT = 'Clicca per visualizzare la sezione '.$LNG->SOLUTION_NAME.' del form';
$LNG->QUICKFORM_R_STEP2_HINT = 'Clicca per visualizzare la sezione '.$LNG->CLAIM_NAME.'  del form';
$LNG->QUICKFORM_STEP3_HINT = 'Clicca per visualizzare la sezione '.$LNG->EVIDENCE_NAME.'  del form';
$LNG->QUICKFORM_STEP4_HINT = 'Clicca per visualizzare la sezione '.$LNG->RESOURCES_NAME.' del form';
$LNG->QUICKFORM_STEP5_HINT = 'Clicca per visualizzare la sezione '.$LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.', '.$LNG->THEMES_NAME.' del form';

$LNG->QUICKFORM_P_STEP1_SECTION_HEADING = 'Che domanda stai esplorando?';
$LNG->QUICKFORM_R_STEP1_SECTION_HEADING = 'Che domanda di ricerca stai esplorando?';
$LNG->QUICKFORM_P_STEP2_SECTION_HEADING = 'Che '.$LNG->SOLUTION_NAME.' puoi proporre per affrontare questa '.$LNG->ISSUE_NAME.'?';
$LNG->QUICKFORM_R_STEP2_SECTION_HEADING = 'Che '.$LNG->CLAIM_NAME.' si può fare che aiuta a rispondere alla tua domanda di ricerca?';
$LNG->QUICKFORM_P_STEP3_SECTION_HEADING = "C'è qualche ".$LNG->EVIDENCE_NAME." a supporto della tua ".$LNG->SOLUTION_NAME_SHORT."?";
$LNG->QUICKFORM_R_STEP3_SECTION_HEADING = "C'è qualche ".$LNG->EVIDENCE_NAME." a supporto della tua ".$LNG->CLAIM_NAME_SHORT."?";
$LNG->QUICKFORM_STEP4_SECTION_HEADING = 'Che '.$LNG->RESOURCES_NAME.' puoi indicare per supportare la tua '.$LNG->EVIDENCE_NAME.'?';
$LNG->QUICKFORM_STEP5_SECTION_HEADING = 'Connetti la tua storia a un '.$LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.', '.$LNG->THEMES_NAME.' e ai Tags';

$LNG->QUICKFORM_P_STEP1_SECTION_MESSAGE = 'Aggiungi una domanda/questione che stai esplorando e che pensi sia particolarmente importante da affrontare';
$LNG->QUICKFORM_R_STEP1_SECTION_MESSAGE = 'Aggiungi una domanda/questione che stai esplorando e che pensi sia particolarmente importante da affrontare';
$LNG->QUICKFORM_P_STEP2_SECTION_MESSAGE = 'Aggiungi una '.$LNG->SOLUTION_NAME.' alla '.$LNG->ISSUE_NAME.' che hai proposto';
$LNG->QUICKFORM_R_STEP2_SECTION_MESSAGE = 'Aggiungi una '.$LNG->CLAIM_NAME.' che affronti la '.$LNG->ISSUE_NAME.' che hai proposto';
$LNG->QUICKFORM_P_STEP3_SECTION_MESSAGE = 'Aggiungi una '.$LNG->EVIDENCE_NAME.' a supporto della tua '.$LNG->SOLUTION_NAME.'  specificando che tipo di'.$LNG->EVIDENCE_NAME.' è ('.implode(",",$CFG->EVIDENCE_TYPES).')';
$LNG->QUICKFORM_R_STEP3_SECTION_MESSAGE = 'Aggiungi una '.$LNG->EVIDENCE_NAME.' a supporto della tua '.$LNG->CLAIM_NAME.' specificando che tipo di'.$LNG->EVIDENCE_NAME.' è ('.implode(",",$CFG->EVIDENCE_TYPES).')';
$LNG->QUICKFORM_STEP4_SECTION_MESSAGE = "Le risorse possono essere Risorse Web (es.link URL a siti web, video YouTube, presentazioni, etc) o Pubblicazioni. per favore cambia il 'Tipo' se vuoi aggiungere un link URL alla pubblicazione.";
$LNG->QUICKFORM_P_STEP5_SECTION_MESSAGE_ORG = 'Associa la '.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME_SHORT.' e '.$LNG->EVIDENCE_NAME.' che hai inserito come specificata da un particolare '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.'.';
$LNG->QUICKFORM_R_STEP5_SECTION_MESSAGE_ORG = 'Associa '.$LNG->ISSUE_NAME.', '.$LNG->CLAIM_NAME_SHORT.' e '.$LNG->EVIDENCE_NAME.' che hai inserito ome specificata da un particolare  '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.'.';
$LNG->QUICKFORM_P_STEP5_SECTION_MESSAGE_THEME = 'Associa uno o più'.$LNG->THEME_NAME.'a '.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME_SHORT.', '.$LNG->EVIDENCE_NAME.' e '.$LNG->RESOURCES_NAME.' che hai aggiunto.';
$LNG->QUICKFORM_R_STEP5_SECTION_MESSAGE_THEME = 'Associa uno o più'.$LNG->THEME_NAME.' a '.$LNG->ISSUE_NAME.', '.$LNG->CLAIM_NAME_SHORT.', '.$LNG->EVIDENCE_NAME.' e '.$LNG->RESOURCES_NAME.' che hai aggiunto.';
$LNG->QUICKFORM_P_STEP5_SECTION_MESSAGE_TAG = 'Aggiungi tutti i tags che vuoi siano associati a '.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME_SHORT.', '.$LNG->EVIDENCE_NAME.' e '.$LNG->RESOURCES_NAME.' che hai aggiunto.';
$LNG->QUICKFORM_R_STEP5_SECTION_MESSAGE_TAG = 'Aggiungi tutti i tags che vuoi siano associati a '.$LNG->ISSUE_NAME.', '.$LNG->CLAIM_NAME_SHORT.', '.$LNG->EVIDENCE_NAME.' e '.$LNG->RESOURCES_NAME.' che hai aggiunto.';

$LNG->FORM_QUICK_HEADER_MESSAGE = 'per favore tieni presente che tutti i dati che inserisci qui saranno visibili pubblicamente su questo sito da altri utenti.';
$LNG->FORM_QUICK_REQUIRED_FIELDS_MESSAGE_PART1 = "(campi con un";
$LNG->FORM_QUICK_REQUIRED_FIELDS_MESSAGE_PART2 = "sono obbligatori solo se vuoi aggiungere quell'elemento)";
$LNG->FORM_QUICK_PRACTITIONER_STORY_TITLE = 'Aggiungi la tua storia come Professionista';
$LNG->FORM_QUICK_RESEARCHER_STORY_TITLE = 'Aggiungi la tua storia come ricercatore';
$LNG->FORM_QUICK_ISSUE_DESC_ERROR = 'per favore inserisci una sintesi della '.$LNG->ISSUE_NAME.' e la descrizione prima di provare a pubblicare';
$LNG->FORM_QUICK_SOLUTION_DESC_ERROR = 'per favore inserisci un'.$LNG->SOLUTION_NAME.' summary as well as la descrizione prima di provare a pubblicare';
$LNG->FORM_QUICK_CLAIM_DESC_ERROR = 'er favore inserisci una sintesi della '.$LNG->CLAIM_NAME.' e la descrizione prima di provare a pubblicare';
$LNG->FORM_QUICK_EVIDENCE_DESC_ERROR = 'er favore inserisci una sintesi della'.$LNG->EVIDENCE_NAME.' e la descrizione prima di provare a pubblicare';

/** OTHER FORMS **/
$LNG->FORM_REGISTER_OPEN_TITLE = 'Registrati';
$LNG->FORM_REGISTER_REQUEST_TITLE = 'Richiesta di iscrizione';
$LNG->FORM_REGISTER_ADMIN_TITLE = 'Registra un nuovo utente';
$LNG->FORM_REGISTER_EMAIL = 'Email:';
$LNG->FORM_REGISTER_DESC = 'Descrizione';
$LNG->FORM_REGISTER_PASSWORD = 'Password:';
$LNG->FORM_REGISTER_PASSWORD_CONFIRM = 'Conferma Password:';
$LNG->FORM_REGISTER_NAME = 'Nome e Cognome:';
$LNG->FORM_REGISTER_INTEREST = "Interesse nell'Evidence Hub:";
$LNG->FORM_REGISTER_LOCATION = 'Luogo: (città)';
$LNG->FORM_REGISTER_COUNTRY = 'Paese...';
$LNG->FORM_REGISTER_HOMEPAGE = 'Homepage:';
$LNG->FORM_REGISTER_NEWSLETTER = 'Newsletter:';
$LNG->FORM_REGISTER_CAPTCHA = 'Sei umano?';
$LNG->FORM_REGISTER_SUBMIT_BUTTON = 'Registrati';
$LNG->FORM_REGISTER_REQUEST_DESC = ' Descrizione personale';
$LNG->FORM_REGISTER_IMAGE_ERROR = "per favore modifica il tuo profilo  e carica una nuova immagine una volta completata la iscrizione.";

$LNG->REGISTRATION_SUCCESSFUL_TITLE = "Iscrizione completata correttamente";
$LNG->REGISTRATION_SUCCESSFUL_MESSAGE = "Riceverai a breve un'email. Devi cliccare sul link al suo interno per validare la tua mail e completare la iscrizione.";
$LNG->REGISTRATION_SUCCESSFUL_MESSAGE_NEW = "Riceverai a breve un'email di benvenuto.";
$LNG->REGISTRATION_COMPLETE_TITLE = "iscrizione completa";
$LNG->REGISTRATION_FAILED = 'Non è stato possibile completare la tua iscrizione. Per favore riprova';
$LNG->REGISTRATION_FAILED_INVALID = "Non è stato possibile completare la tua iscrizione perché la password inserita non è valida per l'utente indicato. Per favore riprova";
$LNG->REGISTRATION_SUCCESSFUL_LOGIN = "Adesso puoi <a href='".$CFG->homeAddress."ui/pages/login.php'>log in</a>";

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE = 'Richiesta di iscrizione ricevuta';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE = 'Grazie per il tuo interesse a contribuire a questo Evidence Hub .<br> La tua richiesta di iscrizione è stata inviato e verrai ricontattato a breve.';

$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE_ADMIN = 'iscrizione del nuovo utente completata correttamente';
$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE_ADMIN = "Una mail è stata inviata al nuovo utente con i dettagli di accesso.";

$LNG->FORM_HEADER_MESSAGE = 'Per favore tieni presente che tutti i dati che inserisci qui saranno visibili pubblicamente su questo sito da altri utenti.';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART1 = '(I campi con';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART2 = 'sono obbligatori';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART3 = ', a meno che non siano in una sottosezione facoltativa che non stai completando)';
$LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART4 = '.)';

$LNG->FORM_RELEVANCE_LABEL = 'Perchè è rilevante per';
$LNG->FORM_REQUIRED_FIELDS = 'indica il campo obbligatorio';
$LNG->FORM_LABEL_SUMMARY = 'Sintesi:';
$LNG->FORM_LABEL_DESC = 'Descrizione';
$LNG->FORM_LABEL_TYPE = 'Tipo:';
$LNG->FORM_LABEL_EVIDENCE_TYPE = $LNG->EVIDENCE_NAME.' Tipo:';
$LNG->FORM_LABEL_EVIDENCE_RESOURCES = $LNG->EVIDENCE_NAME.' '.$LNG->RESOURCES_NAME.':';
$LNG->FORM_LABEL_ORG_PROJECT = $LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.':';
$LNG->FORM_LABEL_ORG_PROJECT_CHOICE = $LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.'...';
$LNG->FORM_LABEL_URL = 'Url:';
$LNG->FORM_LABEL_TITLE = 'Titolo:';
$LNG->FORM_LABEL_DOI = 'DOI:';
$LNG->FORM_LABEL_NAME = 'Nome:';
$LNG->FORM_LABEL_THEME = $LNG->THEMES_NAME.':';
$LNG->FORM_LABEL_TAGS = 'Aggiungi Tags:';
$LNG->FORM_LABEL_TAGS_HINT = '(separati da virgola)';
$LNG->FORM_LABEL_ADDED_TAGS = 'Aggiungi Tags:';
$LNG->FORM_LABEL_ADDED_TAGS_HINT = '(Seleziona per rimuovere)';
$LNG->FORM_LABEL_PROJECT_STARTED_DATE = 'Data di inizio:';
$LNG->FORM_LABEL_PROJECT_ENDED_DATE = 'Data di fine:';
$LNG->FORM_LABEL_LOCATION = 'Luogo';
$LNG->FORM_LABEL_ADDRESS1 = 'Indirizzo 1:';
$LNG->FORM_LABEL_ADDRESS2 = 'Indirizzo 2:';
$LNG->FORM_LABEL_TOWN = 'Città:';
$LNG->FORM_LABEL_POSTAL_CODE = 'CAP:';
$LNG->FORM_LABEL_COUNTRY = 'Paese:';
$LNG->FORM_LABEL_COUNTRY_CHOICE = 'Paese...';
$LNG->FORM_LABEL_CHALLENGES_TOGGLE = 'Mostra/Nascondi '.$LNG->CHALLENGES_NAME.':';
$LNG->FORM_LABEL_CHALLENGES = $LNG->CHALLENGES_NAME.':';
$LNG->FORM_LABEL_PARTNERS = 'Partner:';
$LNG->FORM_LABEL_PARTNERS_CHOICE = $LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.'...';
$LNG->FORM_LABEL_RESOURCES = $LNG->RESOURCES_NAME.':';
$LNG->FORM_LABEL_CLIP = 'Clip:';
$LNG->FORM_LABEL_CLIPS = 'Clips:';
$LNG->FORM_LABEL_MANAGED = 'Gestito:';

$LNG->FORM_DESC_PLAIN_TEXT_LINK = 'Testo normale';
$LNG->FORM_DESC_PLAIN_TEXT_HINT = 'Passa a testo normale. La formattazione andrà persa.';
$LNG->FORM_DESC_HTML_TEXT_LINK = 'Formattazione';
$LNG->FORM_DESC_HTML_TEXT_HINT = 'Mostra la barra di formattazione.';
$LNG->FORM_DESC_HTML_SWITCH_WARNING = 'Sei sicuro di voler passare a testo normale? Attenzione: la formattazione andrà persa.';

$LNG->FORM_AUTOCOMPLETE_TITLE_HINT = 'Prova a recuperare il titolo del sito web dai dati della pagina del sito web';
$LNG->FORM_SELECT_RESOURCE_HINT = 'Seleziona/aggiungi una '.$LNG->RESOURCE_NAME.' per supportare questo';

$LNG->FORM_BUTTON_REMOVE = 'Elimina';
$LNG->FORM_BUTTON_REMOVE_CAP = 'Elimina';
$LNG->FORM_BUTTON_SELECT_ANOTHER = 'Seleziona un altro';

$LNG->FORM_BUTTON_ADD_ANOTHER = "Aggiungi un'altra";

$LNG->FORM_BUTTON_ADD_ANOTHER_THEME = "Aggiungi un altro ".$LNG->THEME_NAME;
$LNG->FORM_BUTTON_ADD_ANOTHER_RESOURCE = "Aggiungi un'altra ".$LNG->RESOURCE_NAME;
$LNG->FORM_BUTTON_ADD_ANOTHER_PARTNER = "Aggiungi un altro";
$LNG->FORM_BUTTON_ADD_ANOTHER_SEE_ALSO ="Aggiungi un altro";

$LNG->FORM_BUTTON_CHANGE = 'Modifica';
$LNG->FORM_BUTTON_ADD = 'Aggiungi';
$LNG->FORM_BUTTON_ADD_NEW = 'Aggiungi nuovo';
$LNG->FORM_BUTTON_PUBLISH = 'Pubblica';
$LNG->FORM_BUTTON_CANCEL = 'Cancella';
$LNG->FORM_BUTTON_CLOSE = 'Cchiudi';
$LNG->FORM_BUTTON_CONTINUE = 'Continua';
$LNG->FORM_BUTTON_SAVE = 'Salva';
$LNG->FORM_BUTTON_NEXT = 'Successivo   >';
$LNG->FORM_BUTTON_BACK = '< Indietro  ';
$LNG->FORM_BUTTON_SKIP = 'Salta   >';
$LNG->FORM_BUTTON_PRINT_PAGE = 'Stampa la pagina';
$LNG->FORM_BUTTON_SELECT_MANAGED_PROJECT_TEXT = 'Aggiungi';
$LNG->FORM_BUTTON_SELECT_MANAGED_PROJECT_HINT = 'Seleziona/aggiungi un '.$LNG->PROJECT_NAME.' che gestisci';
$LNG->FORM_MANAGED_PROJECTS_HINT = "Un'altra riga sarà aggiunta automaticamente";

$LNG->FORM_ERROR_NOT_ADMIN = 'Non hai i permessi per visualizzare questa pagina';
$LNG->FORM_ERROR_MESSAGE = 'Sono stati riscontrati i seguenti problemi, per favore  riprova';
$LNG->FORM_ERROR_MESSAGE_LOGIN = 'Sono stati riscontrati i seguenti problemi  con il tuo tentativo di accesso:';
$LNG->FORM_ERROR_MESSAGE_iscrizione= 'Sono stati riscontrati i seguenti problemi con la tua iscrizione, per favore  riprova:';
$LNG->FORM_ERROR_THEME = 'per favore assicurati di sceglierne almeno uno '.$LNG->THEME_NAME;
$LNG->FORM_ERROR_NOT_ADMIN = "Spiacenti, devi essere un amministratore per accedere a questa pagina";
$LNG->FORM_ERROR_PASSWORD_MISMATCH = "La password e la conferma della password non corrispondono. Per favore  riprova.";
$LNG->FORM_ERROR_PASSWORD_MISSING = "Per favore inserisci una password.";
$LNG->FORM_ERROR_NAME_MISSING = 'Per favore inserisci il tuo nome completo.';
$LNG->FORM_ERROR_INTEREST_MISSING = "Per favore inserisci il motivo per cui ti interessa avere un account.";
$LNG->FORM_ERROR_URL_INVALID = "Per favore inserisci un URL valido completo (incluso 'https://') per la tua home page.";
$LNG->FORM_ERROR_EMAIL_INVALID = "Per favore inserisci un indirizzo mail valido.";
$LNG->FORM_ERROR_EMAIL_USED = "Questo indirizzo mail è già in uso, per favore accedo o seleziona un altro indirizzo.";
$LNG->FORM_ERROR_CAPTCHA_INVALID = "Il reCAPTCHA non è stato inserito correttamente. Per favore riprova.";
$LNG->FORM_ERROR_MAILCHIMP_SUBSCRIPTION = "La iscrizione è completa, ma l'iscrizione alla Newsletter non ha avuto soggetto.";

$LNG->FORM_TITLE_CURRENT_ITEM = "L'elemento attuale";
$LNG->FORM_CONNECT_RELEVANCE_SECTION = 'Facoltativamente, dì perché stai effettuando questa connessione';
$LNG->FORM_THEME_CREATE_ERROR_MESSAGE = 'Si è verificato un problema durante la creazione del '.$LNG->THEME_NAME.':';
$LNG->FORM_QUICK_THANKS = 'Grazie per aver aggiunto la tua storia ';

// Tag manager / Usage viewer
$LNG->FORM_TAG_MANAGER_TITLE = 'Gestisci i Tag';
$LNG->FORM_TAG_MANAGER_NAME_LABEL = 'Nome';
$LNG->FORM_TAG_MANAGER_ACTIONS_LABEL = 'Azioni';
$LNG->FORM_TAG_MANAGER_EDIT_LINK = 'modifica';
$LNG->FORM_TAG_MANAGER_DELETE_LINK = 'cancella';
$LNG->FORM_TAG_MANAGER_VIEW_USAGE_LINK = 'visualizza utilizzo';
$LNG->FORM_TAG_MANAGER_DELETE_MESSAGE_PART1 = 'Sei sicuro di voler cancellare il tag';
$LNG->FORM_TAG_MANAGER_DELETE_MESSAGE_PART2 = "?\\n\\n Questo tag verrà rimosso da tutti gli elementi hai taggato con esso. Potresti voler 'visualizzare l'utilizzo' prima, poiché questa azione non può essere annullata.";
$LNG->FORM_TAG_MANAGER_NAME_ERROR = 'Devi inserire un tag.';
$LNG->FORM_TAG_MANAGER_TAGID_ERROR = "Errore durante il passaggio dell'ID tag.";
$LNG->FORM_TAG_USAGE_TITLE = 'visualizza utilizzo per:';
$LNG->FORM_TAG_USAGE_NO_ITEMS_MESSAGE = 'Non hai creato alcun articolo utilizzando questo tag';

//Selector
$LNG->FORM_SELECTOR_TITLE_DEFAULT = 'Seleziona un elemento';
$LNG->FORM_SELECTOR_TITLE_CHALLENGE = 'Seleziona un '.$LNG->CHALLENGE_NAME;
$LNG->FORM_SELECTOR_TITLE_RESOURCE = 'Seleziona una '.$LNG->RESOURCE_NAME;
$LNG->FORM_SELECTOR_TITLE_EVIDENCE = 'Seleziona una '.$LNG->EVIDENCE_NAME;
$LNG->FORM_SELECTOR_TITLE_ISSUE = 'Seleziona una '.$LNG->ISSUE_NAME;
$LNG->FORM_SELECTOR_TITLE_SOLUTION = 'Seleziona una '.$LNG->SOLUTION_NAME;
$LNG->FORM_SELECTOR_TITLE_CLAIM = 'Seleziona una '.$LNG->CLAIM_NAME;
$LNG->FORM_SELECTOR_TITLE_PROJECT = 'Seleziona un '.$LNG->PROJECT_NAME;
$LNG->FORM_SELECTOR_TITLE_ORG = 'Seleziona un '.$LNG->ORG_NAME;
$LNG->FORM_SELECTOR_TITLE_PROJECTORG = 'Seleziona un '.$LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME;
$LNG->FORM_SELECTOR_SEARCH_ERROR = 'Si è verificato un errore durante il recupero della ricerca dal server';
$LNG->FORM_SELECTOR_NOT_ITEMS = 'Non hai creato nessun elemento del tipo richiesto';
$LNG->FORM_SELECTOR_SEARCH_LABEL = 'Cerca';
$LNG->FORM_SELECTOR_SEARCH_MESSAGE = '( Questa è una ricerca per parola/frase chiave. Lascia vuoto per elencare tutto)';
$LNG->FORM_SELECTOR_SEARCH_EMPTY_MESSAGE = 'Digita una parola chiave o una frase nella casella di ricerca in alto';
$LNG->FORM_SELECTOR_TAB_MINE = 'Mio';
$LNG->FORM_SELECTOR_TAB_SEARCH_RESULTS = 'Cerca risultati';

//Activity Forms
$LNG->FORM_ACTIVITY_HEADING = 'Attività recenti per';
$LNG->FORM_ACTIVITY_TABLE_HEADING_DATE = 'Data';
$LNG->FORM_ACTIVITY_TABLE_HEADING_TYPE = 'Tipo';
$LNG->FORM_ACTIVITY_TABLE_HEADING_DONEBY = 'Fatto da';
$LNG->FORM_ACTIVITY_TABLE_HEADING_ACTION = 'Azione';
$LNG->FORM_ACTIVITY_TABLE_HEADING_ITEM = 'Elemento';
$LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING = 'ha iniziato a seguire';
$LNG->FORM_ACTIVITY_ACTION_STARTED_FOLLOWING_ITEM = 'ha iniziato a seguire questo elemento';
$LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED = 'promosso';
$LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED = 'declassato';
$LNG->FORM_ACTIVITY_ACTION_VOTE_PROMOTED_ITEM = 'promosso questo elemento';
$LNG->FORM_ACTIVITY_ACTION_VOTE_DEMOTED_ITEM = 'declassato questo elemento';
$LNG->FORM_ACTIVITY_ACTION_ADDED = 'aggiunto';
$LNG->FORM_ACTIVITY_ACTION_EDITED = 'modificato';
$LNG->FORM_ACTIVITY_ACTION_ADDED_ITEM = 'ha aggiunto questo elemento';
$LNG->FORM_ACTIVITY_ACTION_EDITED_ITEM = 'ha modificato questo elemento';
$LNG->FORM_ACTIVITY_ACTION_CONNECTED = 'connesso';
$LNG->FORM_ACTIVITY_ACTION_DESOCIATED = 'elimina connessione';
$LNG->FORM_ACTIVITY_ACTION_ADDED_THEME = "ha aggiunto questo ".$LNG->THEME_NAME." a";
$LNG->FORM_ACTIVITY_ACTION_ADDED_RESOURCE = "ha aggiunto la ".$LNG->RESOURCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_PRO = "ha aggiunto una ".$LNG->EVIDENCE_NAME." a favore";
$LNG->FORM_ACTIVITY_ACTION_ADDED_EVIDENCE_CON = "ha aggiunto una ".$LNG->EVIDENCE_NAME." contro";
$LNG->FORM_ACTIVITY_ACTION_CONNECTED_EVIDENCE = "Associato a ".$LNG->EVIDENCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_CONNECTED_WITH = "Ha associato questo a";
$LNG->FORM_ACTIVITY_ACTION_REMOVED_THEME = "rimuovi ".$LNG->THEME_NAME." da";
$LNG->FORM_ACTIVITY_ACTION_REMOVED = "rimosso";
$LNG->FORM_ACTIVITY_ACTION_REMOVED_RESOURCE = "ha rimosso la ".$LNG->RESOURCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_REMOVED_EVIDENCE = "ha rimosso la ".$LNG->EVIDENCE_NAME;
$LNG->FORM_ACTIVITY_ACTION_REMOVED_ASSOCIATION = "ha rimosso la connessione con";
$LNG->FORM_ACTIVITY_ACTION_INDICATED_THAT = 'ha indicato che';
$LNG->FORM_ACTIVITY_ACTION_STRONG_SOLUTION = 'era una '.$LNG->SOLUTION_NAME_SHORT.' forte per';
$LNG->FORM_ACTIVITY_ACTION_SOUND_CLAIM = 'era una '.$LNG->CLAIM_NAME_SHORT.' robusta per';
$LNG->FORM_ACTIVITY_ACTION_CONVINCING_EVIDENCE = 'era convincente '.$LNG->EVIDENCE_NAME.' per';
$LNG->FORM_ACTIVITY_ACTION_SOUND_EVIDENCE = 'era una '.$LNG->EVIDENCE_NAME.' robusta per';
$LNG->FORM_ACTIVITY_ACTION_PROMOTED = 'dovrebbe essere promosso contro';
$LNG->FORM_ACTIVITY_ACTION_WEAK_SOLUTION = 'era una '.$LNG->SOLUTION_NAME_SHORT.' debole per';
$LNG->FORM_ACTIVITY_ACTION_UNSOUND_CLAIM = 'era una '.$LNG->CLAIM_NAME_SHORT.' debole per';
$LNG->FORM_ACTIVITY_ACTION_UNCONVINCING_EVIDENCE = 'non era una '.$LNG->EVIDENCE_NAME.' convincente per';
$LNG->FORM_ACTIVITY_ACTION_UNSOUND_EVIDENCE = 'era una '.$LNG->EVIDENCE_NAME.' debole per';
$LNG->FORM_ACTIVITY_ACTION_DEMOTED = 'sdovrebbe essere promosso contro';
$LNG->FORM_ACTIVITY_LABEL_WITH = 'con';
$LNG->FORM_ACTIVITY_LABEL_FROM = 'da';
$LNG->FORM_ACTIVITY_PROBLEM_MESSAGE = 'Sono stati riscontrati i seguenti problemi nel recuperare i dati delle attività: ';

//Form Print
$LNG->FORM_PRINT_LOADING_MESSAGE = "L'operazione potrebbe richiedere circa un minuto a seconda della quantità di dati associati all'elemento. ";
$LNG->FORM_PRINT_NONE_FOUND_PART1 = 'No';
$LNG->FORM_PRINT_NONE_FOUND_PART2 = 'trovato';
$LNG->FORM_PRINT_FOLLOWERS_HEADING = $LNG->FOLLOWERS_NAME;
$LNG->FORM_PRINT_COMMENTS_HEADING = $LNG->COMMENTS_NAME;
$LNG->FORM_PRINT_RESOURCES_HEADING = $LNG->RESOURCES_NAME;
$LNG->FORM_PRINT_PARTNERS_HEADING = 'Partners';
$LNG->FORM_PRINT_SHARED_THEMES_SOLUTION_HDEAING = $LNG->SOLUTIONS_NAME;
$LNG->FORM_PRINT_SHARED_THEMES_CLAIM_HDEAING = $LNG->CLAIMS_NAME;
$LNG->FORM_PRINT_SHARED_THEMES_ISSUE_HDEAING = $LNG->ISSUES_NAME;
$LNG->FORM_PRINT_SHARED_THEMES_ORGP_HDEAING = $LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME;
$LNG->FORM_PRINT_RESOURCE_EVIDENCE_HEADING = $LNG->EVIDENCES_NAME.' che usa questa '.$LNG->RESOURCE_NAME;
$LNG->FORM_PRINT_CHALLENGE_RESOURCE_HEADING = $LNG->CHALLENGES_NAME.' collegata a questa '.$LNG->RESOURCE_NAME;
$LNG->FORM_PRINT_CHALLENGE_SOLUTION_HEADING = $LNG->SOLUTION_NAME.' proposed';
$LNG->FORM_PRINT_CHALLENGE_ISSUE_HEADING = $LNG->CHALLENGES_NAME.' questa '.$LNG->ISSUE_NAME.' risponde a';
$LNG->FORM_PRINT_ORGP_CHALLENGE_HEADING = 'affrontate'.$LNG->CHALLENGES_NAME;
$LNG->FORM_PRINT_ORGP_CLAIM_HEADING = $LNG->CLAIMS_NAME.' fatte';
$LNG->FORM_PRINT_ORGP_SOLUTION_HEADING = $LNG->SOLUTIONS_NAME.' specificate';
$LNG->FORM_PRINT_ORGP_AddressING_HEADING = $LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.' che affrontano questa';
$LNG->FORM_PRINT_ORGP_SPECIFY_HEADING = $LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.' che specificano questa';
$LNG->FORM_PRINT_ORGP_RESOURCE_HEADING = $LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.' connesse a '.$LNG->RESOURCE_NAME;
$LNG->FORM_PRINT_ISSUE_SOLUTION_HEADING = $LNG->SOLUTIONS_NAME.' a questa';
$LNG->FORM_PRINT_ISSUE_CLAIM_HEADING = $LNG->CLAIMS_NAME.'che rispondono a questa';
$LNG->FORM_PRINT_ISSUE_RESOURCE_HEADING = $LNG->ISSUES_NAME.' connesse a questa '.$LNG->RESOURCE_NAME;
$LNG->FORM_PRINT_ISSUE_CHALLENGE_HEADING = 'connesse'.$LNG->ISSUES_NAME.' a questo';
$LNG->FORM_PRINT_ISSUE_SOLUTION_HEADING = $LNG->ISSUES_NAME.' questa '.$LNG->SOLUTION_NAME.' affronta';
$LNG->FORM_PRINT_SOLUTION_EVIDENCE_PRO_HEADING = 'A favore '.$LNG->EVIDENCE_NAME;
$LNG->FORM_PRINT_SOLUTION_EVIDENCE_CON_HEADING = 'Contro '.$LNG->EVIDENCE_NAME;
$LNG->FORM_PRINT_SOLUTION_ISSUE_HEADING = $LNG->ISSUES_NAME.' affrontata';
$LNG->FORM_PRINT_CLAIM_ORGP_HEADING = $LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.' che afferma questo';
$LNG->FORM_PRINT_CLAIM_EVIDENCE_PRO_HEADING = 'A favore '.$LNG->EVIDENCE_NAME;
$LNG->FORM_PRINT_CLAIM_EVIDENCE_CON_HEADING = 'Contro '.$LNG->EVIDENCE_NAME;
$LNG->FORM_PRINT_CLAIM_ISSUE_HEADING = $LNG->ISSUES_NAME.'ha risposto con questa '.$LNG->CLAIM_NAME;
$LNG->FORM_PRINT_ORG_PROJECT_HEADING = $LNG->PROJECTS_NAME.' gestito';
$LNG->FORM_PRINT_EVIDENCE_SOLUTION_HEADING = $LNG->SOLUTIONS_NAME.' questo è'.$LNG->EVIDENCE_NAME.' per';
$LNG->FORM_PRINT_EVIDENCE_CLAIM_HEADING = $LNG->CLAIMS_NAME.' questo è '.$LNG->EVIDENCE_NAME.' per';
$LNG->FORM_PRINT_THEME_CHALLENGE_HEADING = $LNG->CHALLENGES_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->FORM_PRINT_THEME_ISSUE_HEADING = $LNG->ISSUES_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->FORM_PRINT_THEME_SOLTUION_HEADING = $LNG->SOLUTIONS_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->FORM_PRINT_THEME_CLAIM_HEADING = $LNG->CLAIMS_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->FORM_PRINT_THEME_EVIDENCE_HEADING = $LNG->EVIDENCE_NAME.' con questo'.$LNG->THEME_NAME;
$LNG->FORM_PRINT_THEME_RESOURCE_HEADING = $LNG->RESOURCES_NAME.' con questo '.$LNG->THEME_NAME;
$LNG->FORM_PRINT_THEME_ORGP_HEADING = $LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.' con questo '.$LNG->THEME_NAME;

//Challenge
$LNG->FORM_TITLE_CHALLENGE_ADD = 'Aggiungi a '.$LNG->CHALLENGE_NAME;
$LNG->FORM_TITLE_CHALLENGE_CONNECT = 'Selezione '.$LNG->CHALLENGES_NAME.' e connettile a';
$LNG->FORM_TITLE_CHALLENGE_EDIT = 'Modifica questa '.$LNG->CHALLENGE_NAME;
$LNG->FORM_LABEL_CHALLENGE_SUMMARY = 'Sintesi';
$LNG->FORM_MESSAGE_CHALLENGE = 'Aggiungi una '.$LNG->CHALLENGE_NAME.' che pensi debba essere affrontata';
$LNG->FORM_CHALLENGE_ENTER_SUMMARY_ERROR = 'per favore inserisci '.$LNG->CHALLENGE_NAME.'  prima di provare a pubblicare';
$LNG->FORM_CHALLENGE_NOT_FOUND = 'La '.$LNG->CHALLENGE_NAME.' richiesta non è stata trovata';

//Issue
$LNG->FORM_ISSUE_TITLE_SECTION = 'Aggiungi/Seleziona una '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_CONNECT = $LNG->FORM_ISSUE_TITLE_SECTION.' e connettila a';
$LNG->FORM_ISSUE_TITLE_ADD = 'Aggiungi una '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_TITLE_EDIT = 'Modifica questa '.$LNG->ISSUE_NAME;
$LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR = 'per favore inserisci una sintesi della '.$LNG->ISSUE_NAME.'  prima di provare a pubblicare';
$LNG->FORM_ISSUE_CREATE_ERROR_MESSAGE = 'si è verificato un problema nella creazione della '.$LNG->ISSUE_NAME.':';
$LNG->FORM_ISSUE_HEADING_MESSAGE = 'Aggiungi una domanda che stai esplorando o una '.$LNG->ISSUE_NAME.' che pensi debba essere affrontata';
$LNG->FORM_ISSUE_LABEL_SUMMARY = "Sintesi ".$LNG->ISSUE_NAME.":";
$LNG->FORM_ISSUE_NOT_FOUND = 'la '.$LNG->ISSUE_NAME.' richesta non è stata trovata';
$LNG->FORM_ISSUE_SELECT_EXISTING = 'Seleziona una '.$LNG->ISSUE_NAME.' esistente';

//Claim
$LNG->FORM_CLAIM_LABEL_SUMMARY = "Sintesi ".$LNG->CLAIM_NAME_SHORT.":";
$LNG->FORM_CLAIM_TITLE_ADD = 'Aggiungi una '.$LNG->CLAIM_NAME;
$LNG->FORM_CLAIM_TITLE_EDIT = 'Modifica questa '.$LNG->CLAIM_NAME;
$LNG->FORM_CLAIM_SELECT_EXISTING = 'Seleziona una '.$LNG->CLAIM_NAME_SHORT.' esistente';
$LNG->FORM_CLAIM_TITLE_SECTION = 'Aggiungi/Seleziona una '.$LNG->CLAIM_NAME;
$LNG->FORM_CLAIM_TITLE_CONNECT = $LNG->FORM_CLAIM_TITLE_SECTION.' e connettila a';
$LNG->FORM_CLAIM_ENTER_SUMMARY_ERROR = 'per favore inserisci una sintesi della '.$LNG->CLAIM_NAME.'  prima di provare a pubblicare';
$LNG->FORM_CLAIM_NOT_FOUND = 'la '.$LNG->CLAIM_NAME.' richiesta non è stata trovata';
$LNG->FORM_CLAIM_CREATE_ERROR_MESSAGE = 'si è verificato un problema nella creazione della '.$LNG->CLAIM_NAME;
$LNG->FORM_CLAIM_REMOTE_MESSAGE_LINE1 = 'Se vuoi aggiungere una '.$LNG->RESOURCE_NAME.' a questa '.$LNG->CLAIM_NAME.' una un elemento '.$LNG->EVIDENCE_NAME.' ';
$LNG->FORM_CLAIM_REMOTE_MESSAGE_LINE2 = "Per aggiungere un'affermazione prova a rispondere alla seguente domanda";
$LNG->FORM_CLAIM_REMOTE_MESSAGE_LINE3 = 'Perché questa '.$LNG->RESOURCE_NAME.' supporta questa '.$LNG->CLAIM_NAME.'? Qual è la '.$LNG->EVIDENCE_NAME.' in questa '.$LNG->RESOURCE_NAME.' che ti ha fatto formulare questa '.$LNG->CLAIM_NAME.'?';
$LNG->FORM_CLAIM_REMOTE_MESSAGE_LINE4 = 'per favore aggiungi una spiegazione sotto nei campi "a favore '.$LNG->EVIDENCE_NAME.'" e "Descrizione"';

// Solution
$LNG->FORM_SOLUTION_TITLE_SECTION = 'Aggiungi/Seleziona una '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_CONNECT = $LNG->FORM_SOLUTION_TITLE_SECTION.' e connettila a';
$LNG->FORM_SOLUTION_TITLE_ADD = 'Aggiungi una nuova '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_TITLE_EDIT = 'Modifica questa '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_LABEL_SUMMARY = "Sintesi ".$LNG->SOLUTION_NAME_SHORT.":";
$LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR = 'per favore inserisci una sintesi della '.$LNG->SOLUTION_NAME.'  prima di provare a pubblicare';
$LNG->FORM_SOLUTION_CREATE_ERROR_MESSAGE = 'si è verificato un problema nella creazione della '.$LNG->SOLUTION_NAME;
$LNG->FORM_SOLUTION_NOT_FOUND = 'La'.$LNG->SOLUTION_NAME.' richesta non è stata trovata';
$LNG->FORM_SOLUTION_SELECT_EXISTING = 'Seleziona una '.$LNG->SOLUTION_NAME_SHORT.' esistente';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE1 = 'Se vuoi aggiungere una '.$LNG->RESOURCE_NAME.' a questa '.$LNG->SOLUTION_NAME.' una un elemento '.$LNG->EVIDENCE_NAME.'';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE2 = 'Per aggiungere una '.$LNG->EVIDENCE_NAME.' prova a rispondere alla seguente domanda';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE3 = 'Perché questa '.$LNG->RESOURCE_NAME.' supporta questa '.$LNG->SOLUTION_NAME.'? Qual è la '.$LNG->EVIDENCE_NAME.' in questa '.$LNG->RESOURCE_NAME.' che ti ha fatto aggiungere questa '.$LNG->SOLUTION_NAME.'?';
$LNG->FORM_SOLUTION_REMOTE_MESSAGE_LINE4 = 'per favore aggiungi una speigazione sotto nei campi "a favore '.$LNG->EVIDENCE_NAME.'" e "Descrizione".';

//ORG - PROJECT
$LNG->FORM_TITLE_PROJECT_SECTION = 'Aggiungi/Seleziona un '.$LNG->PROJECT_NAME;
$LNG->FORM_TITLE_PROJECT_CONNECT = $LNG->FORM_TITLE_PROJECT_SECTION.' e connettilo a';
$LNG->FORM_TITLE_ORG_SECTION = 'Aggiungi/Seleziona un '.$LNG->ORG_NAME;
$LNG->FORM_TITLE_ORG_CONNECT = $LNG->FORM_TITLE_ORG_SECTION.' e connettilo a';
$LNG->FORM_TITLE_ORGPROJECT_SECTION = 'Aggiungi/Seleziona un '.$LNG->ORG_NAME." o ".$LNG->PROJECT_NAME;
$LNG->FORM_TITLE_ORGPROJECT_CONNECT = $LNG->FORM_TITLE_ORGPROJECT_SECTION.' e connettilo a';
$LNG->FORM_ORG_TITLE_EDIT = 'Modifica';
$LNG->FORM_ORG_TITLE_ADD = 'Parlaci della tua '.$LNG->ORG_NAME.', dei tuoi '.$LNG->PROJECTS_NAME;
$LNG->FORM_ORG_ENTER_SUMMARY_ERROR = "Per favore inserisci un nome";
$LNG->FORM_ORG_CREATE_ERROR_MESSAGE = 'Non è stato possibile aggiungere/recuperare il '.$LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.'';
$LNG->FORM_ORG_PUBLISH_MESSAGE = "Quando clicchi <b>".$LNG->FORM_BUTTON_PUBLISH."</b> , sarà creata una nuova ".$LNG->ORG_NAME."/".$LNG->PROJECT_NAME." e sarai rimandato alla pagina corrispondente.  <br> Lì sarai in grado di aggiungere ulteriori dettagli come tutti i partner che ha, ";

if ($CFG->HAS_CHALLENGE) {
	$LNG->FORM_ORG_PUBLISH_MESSAGE .= $LNG->CHALLENGES_NAME.' o ';
}
$LNG->FORM_ORG_PUBLISH_MESSAGE .= $LNG->ISSUES_NAME." l'indirizzo ";
if ($CFG->HAS_CLAIM) {
	$LNG->FORM_ORG_PUBLISH_MESSAGE .= $LNG->CLAIMS_NAME;
}
if ($CFG->HAS_CLAIM && $CFG->HAS_SOLUTION) {
	$LNG->FORM_ORG_PUBLISH_MESSAGE .= ' o ';
}
if ($CFG->HAS_SOLUTION) {
	$LNG->FORM_ORG_PUBLISH_MESSAGE .= $LNG->SOLUTIONS_NAME;
}
$LNG->FORM_ORG_PUBLISH_MESSAGE .= ' che propone, o'.$LNG->EVIDENCES_NAME.' che specifica.';
$LNG->FORM_ORG_SELECT_EXISTING = 'Seleziona esistente';
$LNG->FORM_ORG_NOT_FOUND_ERROR_MESSAGE = "Il ".$LNG->ORG_NAME."/".$LNG->PROJECT_NAME." richiesto non è statp trovato";

// Resource
$LNG->FORM_RESOURCE_URL_REQUIRED = 'Devi inserire un URL per ciascuna '.$LNG->RESOURCE_NAME;
$LNG->FORM_RESOURCE_URL_FORMAT_ERROR = 'Un URL non sembra essere formattato correttamente.';
$LNG->FORM_RESOURCE_TITLE_EDIT = 'Modifica una '.$LNG->RESOURCE_NAME;
$LNG->FORM_RESOURCE_TITLE_SECTION = 'Aggiungi/Seleziona una '.$LNG->RESOURCE_NAME;
$LNG->FORM_RESOURCE_TITLE_CONNECT = $LNG->FORM_RESOURCE_TITLE_SECTION.' e connettila a';
$LNG->FORM_RESOURCE_ENTER_URL_ERROR = 'per favore inserisci un URL prima di provare a pubblicare';
$LNG->FORM_RESOURCE_ENTER_TITLE_ERROR = "per favore inserisci un titolo per l'url prima di provare a pubblicare";
$LNG->FORM_RESOURCE_CREATE_ERROR_MESSAGE = 'si è verificato un problema nella creazione della '.$LNG->RESOURCE_NAME.':';
$LNG->FORM_RESOURCE_TITLE_ADD = 'Aggiungi una nuova '.$LNG->RESOURCE_NAME;
$LNG->FORM_RESOURCE_NOT_FOUND = 'La '.$LNG->RESOURCE_NAME.' richiestsnon è stata trovata';
$LNG->FORM_RESOURCE_PERMISSION_ERROR_MESSAGE = 'Non hai i permessi to Modifica questa '.$LNG->RESOURCE_NAME;
$LNG->FORM_RESOURCE_CLIPS_SELECT_TO_REMOVE = '(Seleziona per rimuovere)';
$LNG->FORM_RESOURCE_SELECT_EXISTING = 'Seleziona una '.$LNG->RESOURCE_NAME.' esistente';

// Evidence
$LNG->FORM_EVIDENCE_LABEL_SUMMARY = "Sintesi ".$LNG->EVIDENCE_NAME.":";
$LNG->FORM_EVIDENCE_TITLE_SECTION = 'Aggiungi/Seleziona un pezzo di ';
$LNG->FORM_EVIDENCE_TITLE_SECTION_SUPPORTING = 'A favore';
$LNG->FORM_EVIDENCE_TITLE_SECTION_COUNTER = 'Contro';
$LNG->FORM_EVIDENCE_TITLE_CONNECT = ' e connettila a';
$LNG->FORM_EVIDENCE_TITLE_ADD = 'Aggiungi una '.$LNG->EVIDENCE_NAME;
$LNG->FORM_EVIDENCE_TITLE_EDIT = 'Modifica '.$LNG->EVIDENCE_NAME;
$LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR = 'per favore inserisci una sintesi della '.$LNG->EVIDENCE_NAME.' prima di provare a pubblicare';
$LNG->FORM_EVIDENCE_SELECT_EXISTING = 'Seleziona '.$LNG->EVIDENCE_NAME.' esistente';
$LNG->FORM_EVIDENCE_ALREADY_EXISTS = "Hai già un elemento con quel riepilogo e tipo. Per favore cambia uno o l'altro.";
$LNG->FORM_EVIDENCE_NOT_FOUND = 'La '.$LNG->EVIDENCE_NAME.' richiesta non è stata trovata';
$LNG->FORM_SUPPORTING_EVIDENCE_LABEL = 'A favore '.$LNG->EVIDENCE_NAME;

/** FORM ROLLOVER HINTS **/
//Challenge
$LNG->CHALLENGE_SUMMARY_FORM_HINT = '(obbligatorio)- Inserisci una nuova sintesi della '.$LNG->CHALLENGE_NAME.'. Questa formerà il titolo della'.$LNG->CHALLENGE_NAME.' mostrato nelle liste.';
$LNG->CHALLENGE_THEME_FORM_HINT = '(obbligatorio)- Seleziona almeno un '.$LNG->THEME_NAME.' associato a questa '.$LNG->CHALLENGE_NAME.'. Questi sono usati per raggruppare le '.$LNG->CHALLENGES_NAME.'rispetto ai '.$LNG->THEMES_NAME.' e formulare raccomandazioni basate sulla corrispondenza di '.$LNG->THEME_NAME.' Puoi inserirne più di uno.';
$LNG->CHALLENGE_DESC_FORM_HINT ='(opzionale)  - Inserisci una descrizione più dettagliata della '.$LNG->CHALLENGE_NAME;
$LNG->CHALLENGE_TAG_FORM_HINT ='(opzionale)  - Tag associati a questa  '.$LNG->CHALLENGE_NAME.'.Puoi inserire più di un elemento separato da virgola.';
$LNG->CHALLENGE_TAGADDED_FORM_HINT = "Questa è una lista di tag che hai aggiunto a questa ".$LNG->CHALLENGE_NAME.". Spunta i tag nell'elenco se vuoi cancellarli.";
$LNG->CHALLENGE_REASON_FORM_HINT = 'Descrivi perché pensi  che questa '.$LNG->CHALLENGE_NAME.' sia rilevante per: ';
$LNG->CHALLENGES_FORM_HINT = 'Seleziona la '.$LNG->CHALLENGES_NAME.' con cui desideri relazionarti: ';

// Issues
$LNG->ISSUE_SUMMARY_FORM_HINT = '(obbligatorio)- Inserisci la sintesi di una nuova '.$LNG->ISSUE_NAME.'. Questa formerà il titolo della '.$LNG->ISSUE_NAME.' mostrato nelle liste.';
$LNG->ISSUE_DESC_FORM_HINT = '(opzionale) - Inserisci una descrizione più dettagliata della '.$LNG->ISSUE_NAME;
$LNG->ISSUE_CHALLENGES_FORM_HINT = '(opzionale)  - Seleziona una o più '.$LNG->CHALLENGES_NAME.' a cui questa '.$LNG->ISSUE_NAME.' è collegata.';
$LNG->ISSUE_THEME_FORM_HINT = '(obbligatorio)- Seleziona almeno un '.$LNG->THEME_NAME.' associato a questa '.$LNG->ISSUE_NAME.'. Questi sono usati per creare cluster di '.$LNG->ISSUES_NAME.' rispetto ai '.$LNG->THEMES_NAME.' e formulare raccomandazioni basate sulla corrispondenza di '.$LNG->THEME_NAME.'. Puoi inserirne più di uno.';
$LNG->ISSUE_TAG_FORM_HINT = '(opzionale)  - Tag associati a questa '.$LNG->ISSUE_NAME.'.Puoi inserire più di un elemento  separato da virgola';
$LNG->ISSUE_TAGADDED_FORM_HINT = "Questa è una lista di tag che hai aggiunto a questo ".$LNG->ISSUE_NAME.". Spunta i tag nell'elenco se vuoi cancellarli.";
$LNG->ISSUE_REASON_FORM_HINT = '(opzionale)  - Descrivi perché pensi  che questa '.$LNG->ISSUE_NAME.' sia rilevante per: ';
$LNG->ISSUE_OTHERCHALLENGE_FORM_HINT = "(opzionale)  - Seleziona un'altra ".$LNG->CHALLENGES_NAME." che vuoi collegare a questa ".$LNG->ISSUE_NAME;
$LNG->ISSUE_RESOURCE_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi pubblicazione, sito, immagine  etc.. che faccia parte di o supporti questa  '.$LNG->ISSUE_NAME.'. Puoi inserirne più di uno.';

// Solutions
$LNG->SOLUTION_SUMMARY_FORM_HINT = '(obbligatorio)-  Inserisci la sintesi di una nuova'.$LNG->SOLUTION_NAME.'. Inserisci la sintesi di una nuova';
$LNG->THEME_SUMMARY_FORM_HINT = '(obbligatorio)- Seleziona una o più '.$LNG->THEME_NAME.' Associati a questa '.$LNG->SOLUTION_NAME.'. Queste sono usate per creare cluster di'.$LNG->SOLUTIONS_NAME.' intorno a '.$LNG->THEMES_NAME.' e formulare raccomandazioni basate sulla corrispondenza di '.$LNG->THEME_NAME.'. Puoi inserirne più di uno.';
$LNG->SOLUTION_PRO_FORM_HINT = "inserisci affermazioni a supporto di questa ".$LNG->SOLUTION_NAME.". Aggiungi una sintesi dell'affermazione, e se desideri una descrizione completa e/o un url di un sito web che contribuisce a questa affermazione";
$LNG->SOLUTION_CON_FORM_HINT = "inserisci affermazioni contro di questa".$LNG->SOLUTION_NAME.".  Aggiungi una sintesi dell'affermazione, e se desideri una descrizione completa e/o un url di un sito web che contribuisce a questa affermazione.";
$LNG->SOLUTION_DESC_FORM_HINT = '(opzionale)  - Inserisci una descrizione più dettagliata della '.$LNG->SOLUTION_NAME;
$LNG->SOLUTION_TAG_FORM_HINT = '(opzionale)  - Tag associati a questa '.$LNG->SOLUTION_NAME.'.Puoi inserire più di un elemento  separato da virgola';
$LNG->SOLUTION_TAGADDED_FORM_HINT = "Questa è una lista di tag che hai aggiunto a questa ".$LNG->SOLUTION_NAME.". Spunta i tag nell'elenco se vuoi cancellarli.";
$LNG->SOLUTION_REASON_FORM_HINT = '(opzionale)  - Descrivi perché pensi  che questa '.$LNG->SOLUTION_NAME.' sia rilevante per: ';
// Claims
$LNG->CLAIM_SUMMARY_FORM_HINT = '(obbligatorio)- Inserisci la sintesi di una nuova '.$LNG->CLAIM_NAME.' . Questa formerà il titolo della'.$LNG->CLAIM_NAME.'  mostrato nelle liste.';
$LNG->CLAIM_THEME_FORM_HINT = '(obbligatorio)- Seleziona almeno un '.$LNG->THEME_NAME.' associato a questa '.$LNG->CLAIM_NAME.'. Questi sono usati per creare cluster di '.$LNG->CLAIMS_NAME.' intorno a '.$LNG->THEMES_NAME.' e formulare raccomandazioni basate sulla corrispondenza di'.$LNG->THEME_NAME.'. Puoi inserirne più di uno.';
$LNG->CLAIM_DESC_FORM_HINT = '(opzionale)  - Inserisci una descrizione più dettagliata della '.$LNG->CLAIM_NAME;
$LNG->CLAIM_RESAON_FORM_HINT = '(opzionale)  - Descrivi perché pensi  che questa '.$LNG->CLAIM_NAME.'  sia rilevante per: ';
$LNG->CLAIM_TAG_FORM_HINT = '(opzionale)  - Tag associati a questa '.$LNG->CLAIM_NAME.'.Puoi inserire più di un elemento  separato da virgola';
$LNG->CLAIM_TAGADDED_FORM_HINT = "Questa è una lista di tag che hai aggiunto a questa ".$LNG->CLAIM_NAME.". Spunta i tag nell'elenco se vuoi cancellarli.";
// Evidence
$LNG->EVIDENCE_SUMMARY_FORM_HINT = '(obbligatorio)- Inserisci una sintesi della '.$LNG->EVIDENCE_NAME.'. Questa formerà il titolo della '.$LNG->EVIDENCE_NAME.'  mostrato nelle liste.';
$LNG->EVIDENCE_DESC_FORM_HINT = '(opzionale)  - Inserisci una descrizione più dettagliata della '.$LNG->EVIDENCE_NAME;
$LNG->EVIDENCE_WEBSITE_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi pubblicazione, sito, immagine  etc.. che faccia parte di o supporti questa  '.$LNG->EVIDENCE_NAME.'. Puoi inserirne più di uno.';
$LNG->EVIDENCE_THEME_FORM_HINT = '(obbligatorio)- Seleziona almeno un tema '.$LNG->THEME_NAME.' associato a questa affermazione. Queste sono usate per creare cluster di '.$LNG->EVIDENCES_NAME.' intorno '.$LNG->THEMES_NAME.' a e formulare raccomandazioni basate sulla corrispondenza di '.$LNG->THEME_NAME.' . Puoi inserirne più di uno.';
$LNG->EVIDENCE_TYPE_FORM_HINT = '(obbligatorio)- Seleziona il tipo di '.$LNG->EVIDENCE_NAME.' che vuoi inoltrare - quello di default è '.$CFG->EVIDENCE_TYPES_DEFAULT.', ma se puoi essere più specifico potrebbe essere utile. ';
$LNG->EVIDENCE_TAG_FORM_HINT = '(opzionale)  - Tag associati a questa '.$LNG->EVIDENCE_NAME.'. Puoi inserire più di un elemento  separato da virgola';
$LNG->EVIDENCE_TAGADDED_FORM_HINT = "Questa è una lista di tag che hai aggiunto a questa ".$LNG->EVIDENCE_NAME.". Spunta i tag nell'elenco se vuoi cancellarli.";
$LNG->EVIDENCE_REASON_FORM_HINT = '(opzionale)  - Descrivi perché pensi  che questa '.$LNG->EVIDENCE_NAME.' sia rilevante per: ';
// Resource
$LNG->RESOURCES_FORM_HINT = '(opzionale)  - Inserisci qualsiasi risorsa web che possa supportare la tua '.$LNG->EVIDENCE_NAME;
$LNG->RESOURCES_REMOTE_FORM_HINT = "(opzionale)  - Inserisci qualsiasi ".$LNG->RESOURCES_NAME." wen a supporto della tua ".$LNG->EVIDENCE_NAME.". L'URL del sito in cui ti trovi dovrebbe essere stato inserito automaticamente per te, così come l'eventuale testo selezionato.";
$LNG->RESOURCES_ORG_FORM_HINT = '(opzionale)  - Per favore aggiungi il sito per questo soggetto o progetto, e qualsiasi altra risorsa web che pensi possa essere utile per esplorare questo elemento. Puoi inserirne più di uno.';
$LNG->RESOURCES_CLIP_FORM_HINT = 'Questo è il testo che hai selezionato sul sito ';
$LNG->RESOURCES_TYPE_FORM_HINT = '(obbligatorio)- Seleziona il tipo di '.$LNG->RESOURCE_NAME.' che vuoi inoltrare  - quello di default è '.$CFG->RESOURCE_TYPES_DEFAULT.', che include il sito web e qualsiasi altro url che non sia una pubblicazione.';
$LNG->RESOURCES_THEME_FORM_HINT = '(obbligatorio)- Seleziona almeno un '.$LNG->THEME_NAME.' associato a questa '.$LNG->RESOURCE_NAME.'. Questi sono usati per creare cluster di  '.$LNG->RESOURCES_NAME.' intorno a '.$LNG->THEMES_NAME.'  e formulare raccomandazioni basate sulla corrispondenza di '.$LNG->THEME_NAME.'. Puoi inserirne più di uno.';
$LNG->RESOURCES_TITLE_FORM_HINT = "(obbligatorio)- inserisci un titolo per la ".$LNG->RESOURCE_NAME.". Se non completi il titolo, verrà utilizzato l'URL, che potrebbe non essere l'ideale. Tieni presente che questo titolo verrà utilizzato in tutti gli elenchi di questo ".$LNG->RESOURCE_NAME."<br><br>Se lo desideri, puoi utilizzare il pulsante freccia alla fine del campo URL per provare a recuperare il titolo dalla pagina del sito automaticamente.";
$LNG->RESOURCES_URL_FORM_HINT = "(obbligatorio)- Inserisci l'url della ".$LNG->RESOURCE_NAME;
$LNG->RESOURCES_DOI_FORM_HINT = '(opzionale)  - Inserisci il DOI della pubblicazione che desideri inserire, se conosciuto.';
$LNG->RESOURCES_TAG_FORM_HINT = '(opzionale)  - Tag associati a questa '.$LNG->RESOURCE_NAME.'. Puoi inserire più di un elemento  separato da virgola';
$LNG->RESOURCES_TAGADDED_FORM_HINT = "Questa è una lista di tag che hai aggiunto a questa ".$LNG->RESOURCE_NAME.". Spunta i tag nell'elenco se vuoi cancellarli.";
$LNG->RESOURCES_REASON_FORM_HINT = '(opzionale)  - Descrivi perché pensi  che questa '.$LNG->RESOURCE_NAME.' sia rilevante per: ';
// organization / project
$LNG->ORG_TYPE_FORM_HINT = '(obbligatorio)- Seleziona se stai aggiungendo informazioni relative a un '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME;
$LNG->ORG_TOWN_FORM_HINT = '(opzionale)  - Città dove il '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.' è localizzato. Perchè il soggetto '.$LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.' appaia sulla mappa devi inserire almeno una città.';
$LNG->ORG_COUNTRY_FORM_HINT = '(opzionale)  - Paese in cui il'.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.' è localizzato';
$LNG->ORG_THEME_FORM_HINT = '(obbligatorio)- Seleziona almeno un '.$LNG->THEME_NAME.' di interesse per '.$LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.'. Questi sono usati per creare cluster di  '.$LNG->ORG_NAME.' e '.$LNG->PROJECT_NAME.' ormulare raccomandazioni basate sulla corrispondenza di  '.$LNG->THEME_NAME.'. Puoi inserirne più di uno.';
$LNG->ORG_NAME_FORM_HINT = '(obbligatorio)- Il nome del '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.'.';
$LNG->ORG_PARTNER_FORM_HINT = '(opzionale)  - '.$LNG->ORGS_NAME.' o '.$LNG->PROJECTS_NAME.' con cui la la tua organizzazione '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.' ha una collaborazione stabile. Puoi inserirne più di uno.';
$LNG->ORG_DESC_FORM_HINT = '(opzionale)  - Inserisci una descrizione più dettagliata del tuo '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME;
$LNG->ORG_WEBSITE_FORM_HINT = '(opzionale)  - per favore aggiungi  il sito  per questa '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.' e qualsiasi altra risorsa '.$LNG->RESOURCES_NAME.' e qualsiasi altra risorsa web che pensi possa essere utile per esplorare questo elemento. Puoi inserirne più di uno.';
$LNG->ORG_DATE_FORM_HINT = "(opzionale)  - es: \'14 May 2008\' or \'14-05-2008\'";
$LNG->ORG_CHALLENGES_FORM_HINT = '(opzionale)  - Seleziona qualsiasi '.$LNG->CHALLENGES_NAME.' che pensi possa essere associata a questa '.$LNG->ORGS_NAME.' o '.$LNG->PROJECTS_NAME;
$LNG->ORG_PROJECT_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->PROJECTS_NAME.' che questa '.$LNG->ORG_NAME.' gestisce direttamente. Puoi inserirne più di uno.';
$LNG->ORG_TAG_FORM_HINT = '(opzionale)  - Tag associati a questa  '.$LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.'Puoi inserire più di un elemento  separato da virgola';
$LNG->ORG_TAGADDED_FORM_HINT = "Questa è una lista di tag che hai aggiunto a questa ".$LNG->ORG_NAME."/".$LNG->PROJECT_NAME." Spunta i tag nell'elenco se vuoi cancellarli.";
$LNG->ORG_REASON_FORM_HINT = '(opzionale)  - Descrivi perché pensi  che questa '.$LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.' sia rilevante per: ';

//Comment
$LNG->COMMENT_TAG_FORM_HINT = '(opzionale)  - Tag associati a questa  '.$LNG->COMMENT_NAME.'Puoi inserire più di un elemento  separato da virgola';
$LNG->COMMENT_TAGADDED_FORM_HINT = "Questa è una lista di tag che hai aggiunto a questo ".$LNG->COMMENT_NAME.". Spunta i tag nell'elenco se vuoi cancellarli.";
$LNG->COMMENT_DESC_FORM_HINT = "(obbligatorio)- Inserisci un ".$LNG->COMMENT_NAME." qui. Questo può essere lungo quanto vuoi ma non può essere vuoto. Se si utilizza la formattazione, è comunque necessario del testo, ad esempio non può essere solo un'immagine o un video. Il titolo del commento viene creato utilizzando i primi 100 caratteri.";

//Remote Forms
$LNG->REMOTE_EVIDENCE_SOLUTION_FORM_HINT = 'Inserisci la tua '.$LNG->EVIDENCE_NAME.' a favore della '.$LNG->SOLUTION_NAME.'.  Aggiungi una sintesi della '.$LNG->EVIDENCE_NAME.', e se vuoi una descrizione più dettagliata.';
$LNG->REMOTE_EVIDENCE_CLAIM_FORM_HINT = 'Inserisci la tua '.$LNG->EVIDENCE_NAME.' a favore della '.$LNG->CLAIM_NAME.'.  Aggiungi una sintesi della '.$LNG->EVIDENCE_NAME.', e se vuoi una descrizione più dettagliata.';
$LNG->REMOTE_EVIDENCE_DESC_FORM_HINT = 'Inserisci una descrizione più dettagliata della '.$LNG->EVIDENCE_NAME.' (opzionale) ';
$LNG->REMOTE_EVIDENCE_TYPE_FORM_HINT = 'Seleziona il tipo di '.$LNG->EVIDENCE_NAME.' che vuoi inoltrare  - quello di default è '.$CFG->EVIDENCE_TYPES_DEFAULT.', ma se puoi essere più specifico potrebbe essere utile. ';

/** QUICK FORM HINTS **/
// Issue
$LNG->ISSUE_SUMMARY_QUICKFORM_HINT	= 'Inserisci la sintesi di una nuova '.$LNG->ISSUE_NAME.' . Questa formerà il titolo della';
// Theme
$LNG->THEME_P_QUICKFORM_HINT = 'Seleziona uno o più'.$LNG->THEMES_NAME.' da associare alla '.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->EVIDENCE_NAME.' e qualsiasi '.$LNG->RESOURCES_NAME.' che vuoi aggiungere. Queste sono usate per creare cluster e formulare raccomandazioni basate sulla corrispondenza di '.$LNG->THEME_NAME.' Puoi inserirne più di uno.';
$LNG->THEME_R_QUICKFORM_HINT = 'Seleziona uno o più'.$LNG->THEMES_NAME.' da associare a questa '.$LNG->ISSUE_NAME.', '.$LNG->CLAIM_NAME.', '.$LNG->EVIDENCE_NAME.' e qualsiasi '.$LNG->RESOURCES_NAME.' che vuoi aggiungere. Queste sono usate per creare cluster e   e formulare raccomandazioni basate sulla corrispondenza di '.$LNG->THEME_NAME.'. Puoi inserirne più di uno.';
// Tag
$LNG->TAG_P_QUICKFORM_HINT = 'Inserisci uno o più tag da associare alla '.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.', '.$LNG->EVIDENCE_NAME.' e qualsiasi '.$LNG->RESOURCES_NAME.' che vuoi aggiungere - separato da virgola (opzionale) ';
$LNG->TAG_R_QUICKFORM_HINT = 'Type in uno o piùtags da associare a the '.$LNG->ISSUE_NAME.', '.$LNG->CLAIM_NAME.', '.$LNG->EVIDENCE_NAME.' and any '.$LNG->RESOURCES_NAME.' che vuoi aggiungere - separato da virgola (opzionale) ';
// Solution
$LNG->SOLUTION_SUMMARY_QUICKFORM_HINT = 'Inserisci la sintesi di una nuova '.$LNG->SOLUTION_NAME.'. Questa formerà il titolo della';
// Evidence
$LNG->EVIDENCE_P_QUICKFORM_HINT = 'Inserisci la tua '.$LNG->EVIDENCE_NAME.' per la '.$LNG->SOLUTION_NAME.'.  Aggiungi la sintesi della '.$LNG->EVIDENCE_NAME.', e se vuoi una descrizione più dettagliata.';
$LNG->EVIDENCE_R_QUICKFORM_HINT = 'Inserisci la tua '.$LNG->EVIDENCE_NAME.' per la '.$LNG->CLAIM_NAME.'.  Aggiungi la sintesi della '.$LNG->EVIDENCE_NAME.', e se vuoi una descrizione più dettagliata.';
$LNG->EVIDENCE_TYPE_QUICKFORM_HINT = 'Seleziona il tipo di'.$LNG->EVIDENCE_NAME.' che vuoi inoltrare  - quello di default è '.$CFG->EVIDENCE_TYPES_DEFAULT.', ma se puoi essere più specifico potrebbe essere utile. ';
// Claim
$LNG->CLAIM_SUMMARY_QUICKFORM_HINT = 'Inserisci la sintesi di una nuova '.$LNG->CLAIM_NAME.'. Questa formerà il titolo.';
// Org
$LNG->ORG_P_QUICKFORM_HINT = 'Seleziona un '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.' da associare alla '.$LNG->ISSUE_NAME.', '.$LNG->SOLUTION_NAME.' e '.$LNG->EVIDENCE_NAME.' che vuoi inserire. Se non è nella lista, per favore aggiungila. (opzionale) ';
$LNG->ORG_R_QUICKFORM_HINT = 'Seleziona un '.$LNG->ORG_NAME.' o '.$LNG->PROJECT_NAME.' da associare alla'.$LNG->ISSUE_NAME.', '.$LNG->CLAIM_NAME.' e '.$LNG->EVIDENCE_NAME.' che vuoi inserir. Se non è nella lista, per favore aggiungila. (opzionale) ';

/** QUICK FORM NAV **/
$LNG->ISSUE_QUICKFORM_NAV_HINT = 'Clicca per visualizzare le sezione '.$LNG->ISSUE_NAME.' del form';
$LNG->SOLUTION_QUICKFORM_NAV_HINT = 'Clicca per visualizzare le sezione '.$LNG->SOLUTION_NAME.' del form';
$LNG->CLAIM_QUICKFORM_NAV_HINT = 'Clicca per visualizzare le sezione'.$LNG->CLAIM_NAME.' del form';
$LNG->EVIDENCE_QUICKFORM_NAV_HINT = 'Clicca per visualizzare le sezione '.$LNG->EVIDENCE_NAME.' del form';
$LNG->RESOURCE_QUICKFORM_NAV_HINT = 'Clicca per visualizzare le sezione '.$LNG->RESOURCES_NAME.' del form';
$LNG->THEME_QUICKFORM_NAV_HINT = 'Clicca per visualizzare le sezione '.$LNG->THEMES_NAME.' del form';

/** HOME PAGE NAV HINT **/
$LNG->CHALLENGE_HOME_NAV_HINT = '<p><b>'.$LNG->CHALLENGES_NAME.'</b> è connessa a <b>'.$LNG->ISSUES_NAME.'</b>. Questa connessione spiega che la '.$LNG->CHALLENGE_NAME.' ha uno o più sotto-problemi e può essere mappata (la '.$LNG->ISSUES_NAME.').</p>';

if ($CFG->HAS_CHALLENGE) {
	$LNG->ISSUE_HOME_NAV_HINT = '<p><b>'.$LNG->ISSUES_NAME.'</b> può essere connessa a: '.$LNG->CHALLENGES_NAME.' (connessione a sinistra) e a ';
} else {
	$LNG->ISSUE_HOME_NAV_HINT = '<p><b>'.$LNG->ISSUES_NAME.'</b> cpuò essere connessa a ';
}

if ($CFG->HAS_SOLUTION) {
	$LNG->ISSUE_HOME_NAV_HINT .= $LNG->SOLUTIONS_NAME;
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->ISSUE_HOME_NAV_HINT .= ' e ';
}
if ($CFG->HAS_CLAIM) {
	$LNG->ISSUE_HOME_NAV_HINT .= $LNG->CLAIMS_NAME;
}
$LNG->ISSUE_HOME_NAV_HINT .= ' (connessione a destra).</p>';

if ($CFG->HAS_CHALLENGE) {
	$LNG->ISSUE_HOME_NAV_HINT .= '<p><b>la connessione a sinistra</b> spiega a quale problema di livello superiore la'.$LNG->ISSUE_NAME.' è legata.</p>';
}

if ($CFG->HAS_SOLUTION) {
	$LNG->ISSUE_HOME_NAV_HINT .= '<p><b>la connessione a destra a un '.$LNG->SOLUTION_NAME.'</b> spiega quale soluzione pratica è stata proposta per affrontare la '.$LNG->ISSUE_NAME.'.</p>';
}
if ($CFG->HAS_CLAIM) {
	$LNG->ISSUE_HOME_NAV_HINT .= '<p>La <b>connessione a destra a un '.$LNG->CLAIM_NAME.'</b> spiega quali dichiarazioni di conoscenza possono essere fatte per affrontare la'.$LNG->ISSUE_NAME.'.</p>';
}

$LNG->EVIDENCE_HOME_NAV_HINT = '<p>'.$LNG->EVIDENCES_NAME.' può essere connessa a ';
if ($CFG->HAS_SOLUTION) {
	$LNG->EVIDENCE_HOME_NAV_HINT .= $LNG->SOLUTIONS_NAME;
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->EVIDENCE_HOME_NAV_HINT .= '/';
}
if ($CFG->HAS_CLAIM) {
	$LNG->EVIDENCE_HOME_NAV_HINT .= $LNG->CLAIMS_NAME;
}
$LNG->EVIDENCE_HOME_NAV_HINT .= ' (connessione a sinistra) e a '.$LNG->RESOURCES_NAME.' (connessione a destra).</p>';
$LNG->EVIDENCE_HOME_NAV_HINT .= '<p>The <b>connessione a sinistra</b> spiega quale ';
if ($CFG->HAS_SOLUTION) {
	$LNG->EVIDENCE_HOME_NAV_HINT .= $LNG->SOLUTION_NAME;
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->EVIDENCE_HOME_NAV_HINT .= '/';
}
if ($CFG->HAS_CLAIM) {
	$LNG->EVIDENCE_HOME_NAV_HINT .= $LNG->CLAIM_NAME;
}
$LNG->EVIDENCE_HOME_NAV_HINT .= ' the '.$LNG->EVIDENCE_NAME.' è di supporto o di sfida.</p>';
$LNG->EVIDENCE_HOME_NAV_HINT .= '<p>The <b>connessione a destra</b> spiega quale  '.$LNG->RESOURCES_NAME.' (Risorse web o pubblicazioni di ricerca) può essere indicata a per supportare la '.$LNG->EVIDENCE_NAME.'.</p>';
$LNG->RESOURCE_HOME_NAV_HINT = '<p>'.$LNG->RESOURCE_NAME.' può essere connessa a '.$LNG->EVIDENCE_NAME.'. Questa connessione spiega quale '.$LNG->EVIDENCE_NAME.' può essere desunto o supportato da questa '.$LNG->RESOURCE_NAME.'.</p>';
$LNG->CLAIM_HOME_NAV_HINT = '<p><b>'.$LNG->CLAIMS_NAME.'</b> può essere connessa a '.$LNG->ISSUES_NAME.' (connessione a sinistra) e a '.$LNG->EVIDENCE_NAME.' (connessione a destra).</p>';
$LNG->CLAIM_HOME_NAV_HINT .= '<p>The <b>connessione a sinistra</b> spiega quale  '.$LNG->ISSUE_NAME.' a '.$LNG->CLAIM_NAME.' Addresses.</p>';
$LNG->CLAIM_HOME_NAV_HINT .= '<p>The <b>connessione a destra</b> spiega quale  '.$LNG->EVIDENCE_NAME.' is there that a '.$LNG->CLAIM_NAME.' is sound.</p>';
$LNG->SOLUTION_HOME_NAV_HINT = '<p><b>'.$LNG->SOLUTIONS_NAME.'</b> può essere connessa a '.$LNG->ISSUES_NAME.' (connessione a sinistra) e a '.$LNG->EVIDENCE_NAME.' (connessione a destra).</p>';
$LNG->SOLUTION_HOME_NAV_HINT .= '<p>The <b>connessione a sinistra</b> spiega quale  '.$LNG->ISSUE_NAME.' e '.$LNG->SOLUTION_NAME.' affronta.</p>';
$LNG->SOLUTION_HOME_NAV_HINT .= '<p>The <b>connessione a destra</b> spiega quale  '.$LNG->EVIDENCE_NAME.' esiste su cui una'.$LNG->SOLUTION_NAME.' sta lavorando.</p>';
$LNG->ORG_HOME_NAV_HINT = '<p>'.$LNG->ORGS_NAME.' può essere connessa a una delle categorie di conoscenze a sinistra. '.$LNG->ORGS_NAME.' può gestire uno o più'.$LNG->PROJECTS_NAME.' e collaborare con altri '.$LNG->ORGS_NAME.' e '.$LNG->PROJECTS_NAME.'</p>';
$LNG->PROJECT_HOME_NAV_HINT = '<p>'.$LNG->PROJECTS_NAME.' può essere connessa a una delle categorie di conoscenze a sinistra. '.$LNG->PROJECTS_NAME.' può essere gestito da uno o più'.$LNG->ORGS_NAME.' e collaborare con altri  '.$LNG->PROJECTS_NAME.' e '.$LNG->ORGS_NAME.'</p>';

/** HOME BUTTONS FURTHER INFO TEXT **/

// Issue button
$LNG->ISSUE_HOME_BUTTON_EXTRA = '<p>Le '.$LNG->ISSUES_NAME.' descrivono i problemi chiave portati alla discussione da Città Metropolitana o dai singoli utenti.</p>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<p>Una '.$LNG->ISSUE_NAME.' dovrebbe essere idealmente formulata come domanda e connessa a uno o più temi che si vogliono affrontare.';
//$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<br><span id="issuehomemorebutton" class="active" style="font-weight:normal;text-decoration:underline" onClicca="if ($(\'issuehomemorediv\').style.display == \'none\') { $(\'issuehomemorediv\').style.display = \'block\'; $(\'issuehomemorebutton\').innerHTML = \'read less\'; } else { $(\'issuehomemorediv\').style.display = \'none\';  $(\'issuehomemorebutton\').innerHTML = \'keep reading\';}">continua a leggere</span></p>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<div id="issuehomemorediv" style="float:left;clear:both;width:100%;display:block;margin:0px;padding:0px">';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= 'Ciascun utente può aggiungere una nuova SFIDA o contribuire al dibattito su una '.$LNG->ISSUE_NAME.' esistente aggiungendo:</p>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<ul>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<li>RISORCSE WEB</li>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->ORGS_NAME.' o '.$LNG->PROJECTS_NAME.' che affrontano quella '.$LNG->ISSUE_NAME.'</li>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->THEMES_NAME.' associati</li>';
if ($CFG->HAS_SOLUTION) {
	$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->SOLUTIONS_NAME.'</li>';
}
if ($CFG->HAS_CLAIM) {
	$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->CLAIMS_NAME.' che la affronta</li>';
}
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->COMMENTS_NAME.' generali</li>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '</ul>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<p>La lista delle '.$LNG->ISSUES_NAME.' aggiunte finora può essere esplorata cliccando su <a href="'.$CFG->homeAddress.'#issue-list" title="Clicca per andare alla lista delle '.$LNG->ISSUES_NAME.'">'.$LNG->ISSUES_NAME.'</a>.</p>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '<p>Nella lista delle '.$LNG->ISSUES_NAME.', queste possono essere valutate dalla comunità come più o meno rilevanti, così che la comunità degli utenti possa esprimere quanto si considera ciascuna '.$LNG->ISSUE_NAME.' rilevante rispetto alle altre. La freccia verde in su/la freccia rossa in giù possono essere usate per supportare/osteggiare una '.$LNG->ISSUES_NAME.' nella lista.</p>';
$LNG->ISSUE_HOME_BUTTON_EXTRA .= '</div>';

// Solution Button
$LNG->SOLCLAIM_TEXT = "";
if ($CFG->HAS_SOLUTION) {
	$LNG->SOLCLAIM_TEXT .= $LNG->SOLUTION_NAME;
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->SOLCLAIM_TEXT .= ' or ';
}
if ($CFG->HAS_CLAIM) {
	$LNG->SOLCLAIM_TEXT .= $LNG->CLAIM_NAME;
}
$LNG->SOLCLAIMS_TEXT = "";
if ($CFG->HAS_SOLUTION) {
	$LNG->SOLCLAIMS_TEXT .= $LNG->SOLUTIONS_NAME;
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->SOLCLAIMS_TEXT .= ' e ';
}
if ($CFG->HAS_CLAIM) {
	$LNG->SOLCLAIMS_TEXT .= $LNG->CLAIMS_NAME;
}

$LNG->SOLUTION_HOME_BUTTON_EXTRA = '<p>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= 'Le '.$LNG->SOLCLAIMS_TEXT.' sono usate per rispondere a specifiche '.$LNG->ISSUES_NAME.' e possono essere supportate o osteggiate da specifiche '.$LNG->EVIDENCES_NAME.'.</p>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<p>';
if ($CFG->HAS_SOLUTION) {
	$LNG->SOLUTION_HOME_BUTTON_EXTRA .= "Una ".$LNG->SOLUTION_NAME." descrive una soluzione promossa da professionisti, esperti, decisori o altri stakeholder che fanno parte della comunità.<br>";
}
if ($CFG->HAS_CLAIM) {
	$LNG->SOLUTION_HOME_BUTTON_EXTRA .= "Un ".$LNG->CLAIM_NAME." descrive specifiche dichiarazioni di conoscenza formulate dalle persone all'interno della comunità.</p>";
}
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= "<p>Le ".$LNG->SOLCLAIMS_TEXT." dovrebbero essere connesse a una o più ".$LNG->ISSUES_NAME." aggiunte all'Evidence Hub.";
//$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<br><span id="solutionhomemorebutton" class="active" style="font-weight:normal;text-decoration:underline" onClicca="if ($(\'solutionhomemorediv\').style.display == \'none\') { $(\'solutionhomemorediv\').style.display = \'block\'; $(\'solutionhomemorebutton\').innerHTML = \'read less\'; } else { $(\'solutionhomemorediv\').style.display = \'none\';  $(\'solutionhomemorebutton\').innerHTML = \'keep reading\';}">continua a leggere</span></p>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<div id="solutionhomemorediv" style="float:left;clear:both;width:100%;display:block;margin:0px;padding:0px">';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= 'Ciascun utente può aggiungere una nuova '.$LNG->SOLCLAIM_TEXT.' o contribuire a migliorare quelle esistenti aggiungendo:</p>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<ul>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<li>una '.$LNG->EVIDENCE_NAME.' a favore</li>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<li>una '.$LNG->EVIDENCE_NAME.' contraria</li>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<li>'.$LNG->ORGS_NAME.' oppure  '.$LNG->PROJECTS_NAME.' che lavorano su questa PROPOSTA o soluzione</li>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<li>'.$LNG->THEMES_NAME.' connessi</li>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<li>'.$LNG->COMMENTS_NAME.' generali</li>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '</ul>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= "<p>La ".$LNG->SOLCLAIMS_TEXT." hanno un ruolo chiave all'interno dell'Evidence Hub poiché inquadrano i temi del dibattito.<br>L'obiettivo principale dell'Evidence Hub è promuovere un dibattito comunitario intorno ad esse.</p>";
if ($CFG->HAS_SOLUTION) {
	$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<p>Le '.$LNG->SOLUTIONS_NAME.' aggiunte finora possono essere esplorate cliccando su <a href="'.$CFG->homeAddress.'#solution-list" title="Clicca per andare alla lista delle '.$LNG->SOLUTIONS_NAME.'">'.$LNG->SOLUTIONS_NAME.'</a>. </p>';
}
if ($CFG->HAS_CLAIM) {
	$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<p>Le '.$LNG->CLAIMS_NAME.' aggiunte finora possono essere esplorate cliccando su <a href="'.$CFG->homeAddress.'#claim-list" title="Clicca per andare alla lista delle  '.$LNG->CLAIMS_NAME.' ">'.$LNG->CLAIMS_NAME.'</a>. </p>';
}
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '<p>Nella lista delle '.$LNG->SOLCLAIMS_TEXT.', queste possono essere valutate come più o meno rilevanti, così che la comunità degli utenti possa esprimere quanto si considera ciascuna '.$LNG->SOLCLAIM_TEXT.' rilevante rispetto alle altre. La freccia verde in su/la freccia rossa in giù possono essere usate per supportare/osteggiare una '.$LNG->SOLCLAIMS_TEXT.' nella lista.</p>';
$LNG->SOLUTION_HOME_BUTTON_EXTRA .= '</div>';

// Evidence Button
$LNG->EVIDENCE_HOME_BUTTON_EXTRA = "<p>Una ".$LNG->EVIDENCE_NAME." rappresenta il sunto dello sforzo comunitario per mappare ciò che funziona e ciò che non funziona all'interno della comunità come suggerito dalla pratica o dalla ricerca. Come tali le ".$LNG->EVIDENCES_NAME." sono il cuore dell'Evidence Hub.</p>";
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<p>Idealmente una '.$LNG->EVIDENCE_NAME.' sosterrà o sfiderà almeno una '.$LNG->SOLCLAIM_TEXT.'.';

$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<div id="evidencehomemorediv" style="float:left;clear:both;width:100%;display:block;margin:0px;padding:0px">';
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= 'Ciascun utente può aggiungere una nuova  '.$LNG->EVIDENCE_NAME.' o contribuire al dibattito su una '.$LNG->EVIDENCE_NAME.' esistente aggiungendo:</p>';
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<ul>';
if ($CFG->HAS_SOLUTION) {
	$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->SOLUTIONS_NAME.' che supportano o sfidano una '.$LNG->EVIDENCE_NAME.'</li>';
}
if ($CFG->HAS_CLAIM) {
	$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->CLAIMS_NAME.'che supportano o sfidano una '.$LNG->EVIDENCE_NAME.'</li>';
}
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->ORGS_NAME.' o '.$LNG->PROJECTS_NAME.' che contribuiscono alla '.$LNG->EVIDENCE_NAME.'</li>';
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->THEMES_NAME.' connessi</li>';
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->COMMENTS_NAME.' generali</li>';
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '</ul>';
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<p>La lista delle '.$LNG->EVIDENCES_NAME.' aggiunte può essere esplorata cliccando su '.$LNG->EVIDENCES_NAME.'.</p>';
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '<p>Nella lista delle '.$LNG->EVIDENCES_NAME.', queste possono essere valutate come più o meno rilevanti, così che la comunità degli utenti possa esprimere quanto si considera ciascuna '.$LNG->EVIDENCE_NAME.' rispetto alle altre. La freccia verde in su/la freccia rossa in giù possono essere usate per supportare/osteggiare una '.$LNG->EVIDENCES_NAME.' nella lista. </p>';
$LNG->EVIDENCE_HOME_BUTTON_EXTRA .= '</div>';

// Resource Button
$LNG->RESOURCE_HOME_BUTTON_EXTRA = "<p>Le ".$LNG->RESOURCES_NAME." sono le Pubblicazioni (URL per articoli scientifici) o Risorse Web (URL per qualsiasi altro sito web rilevante) che sono state aggiunte all'Evidence Hub.</p>";
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<p>Le '.$LNG->RESOURCES_NAME.' possono essere usate:</p>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<ul>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<li> per supportare le '.$LNG->EVIDENCES_NAME.' aggiunte al sito</li>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<li>per descrivere un '.$LNG->ORG_NAME_SHORT.' o '.$LNG->PROJECT_NAME.'</li>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '</ul>';
//$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<span id="resourcehomemorebutton" class="active" style="font-weight:normal;text-decoration:underline" onClicca="if ($(\'resourcehomemorediv\').style.display == \'none\') { $(\'resourcehomemorediv\').style.display = \'block\'; $(\'resourcehomemorebutton\').innerHTML = \'read less\'; } else { $(\'resourcehomemorediv\').style.display = \'none\';  $(\'resourcehomemorebutton\').innerHTML = \'keep reading\';}">continua a leggere</span>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<div id="resourcehomemorediv" style="float:left;clear:both;width:100%;display:block;margin:0px;padding:0px">';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<br>Ciascun utente può aggiungere una nuova '.$LNG->RESOURCE_NAME.' o contribuire a migliorare quelle esistenti aggiungendo:</p>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<ul>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->EVIDENCES_NAME.' che derivano da o che supportano quella '.$LNG->RESOURCE_NAME.'</li>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->ORGS_NAME_SHORT.' oppure '.$LNG->PROJECTS_NAME.' connessi a quella '.$LNG->RESOURCE_NAME.'</li>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->THEMES_NAME.' associati</li>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<li>'.$LNG->COMMENTS_NAME.' generali</li>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '</ul>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '<p>La lista delle '.$LNG->RESOURCES_NAME.' può essere esplorata cliccando su <a href="'.$CFG->homeAddress.'#web-list" title="Clicca per andare alla lista delle'.$LNG->RESOURCES_NAME.'">'.$LNG->RESOURCES_NAME.'</a>.</p>';
$LNG->RESOURCE_HOME_BUTTON_EXTRA .= '</div>';

// Org Button
$LNG->ORG_HOME_BUTTON_EXTRA = "<p><b>".$LNG->ORGS_NAME_SHORT."</b> e <b>".$LNG->PROJECTS_NAME."</b> possono essere aggiunti all'Evidence Hub per mappare l'ecosistema organizzativo della comunità.";
$LNG->ORG_HOME_BUTTON_EXTRA .= '<br>La lista dei '.$LNG->ORGS_NAME_SHORT.', '.$LNG->PROJECTS_NAME.' può essere esplorata cliccando su <a href="'.$CFG->homeAddress.'#org-list" title="Clicca per andare alla lista di'.$LNG->ORG_NAME.'/'.$LNG->PROJECT_NAME.'">'.$LNG->ORG_NAME_SHORT.'/'.$LNG->PROJECT_NAME.'</a>.';
$LNG->ORG_HOME_BUTTON_EXTRA .= '<br>'.$LNG->ORGS_NAME_SHORT.' e '.$LNG->PROJECTS_NAME.' possono essere esplorati anche da <a href="'.$CFG->homeAddress.'#org-list" title="Clicca qui per andare a"> geo-location</a>.<br>';
//$LNG->ORG_HOME_BUTTON_EXTRA .= '<span id="orghomemorebutton" class="active" style="font-weight:normal;text-decoration:underline" onClick="if ($(\'orghomemorediv\').style.display == \'none\') { $(\'orghomemorediv\').style.display = \'block\'; $(\'orghomemorebutton\').innerHTML = \'read less\'; } else { $(\'orghomemorediv\').style.display = \'none\';  $(\'orghomemorebutton\').innerHTML = \'keep reading\';}">continua a leggere</span></p>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '<div id="orghomemorediv" style="float:left;clear:both;width:100%;display:block;margin:0px;padding:0px">';
$LNG->ORG_HOME_BUTTON_EXTRA .= 'Ciasun utente può inserire un nuovo '.$LNG->ORG_NAME_SHORT.'/'.$LNG->PROJECT_NAME.' aggiungendo:<br>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '<ul>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '<li>organizzazioni e partner che promuovono progetti, servizi o iniziative rilevanti per i temi dello sviluppo sostenibile</li>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '<li>'.$LNG->ISSUES_NAME;
$LNG->ORG_HOME_BUTTON_EXTRA .= ' affrontate da singoli '.$LNG->PROJECT_NAME.'</li>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '<li>'.$LNG->SOLUTIONS_NAME.' o '.$LNG->EVIDENCES_NAME.' supportate da un '.$LNG->PROJECT_NAME.'</li>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '<li>'.$LNG->THEMES_NAME.' associati</li>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '<li>'.$LNG->COMMENTS_NAME.' generali</li>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '</ul>';
$LNG->ORG_HOME_BUTTON_EXTRA .= '</div>';

// Story Button
$LNG->STORY_HOME_BUTTON_EXTRA = "<p>Che tu sia nuovo sul sito o desideri inserire molti contenuti in una volta sola, o se sei un membro della community e desideri aggiungere conoscenze sul tuo lavoro recente, allora il modo migliore per aggiungere contenuti all'Evidence Hub è inserire una ";
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->STORY_HOME_BUTTON_EXTRA .= '"Storia professionale" o una "Storia di ricerca".<br>';
} else {
	$LNG->STORY_HOME_BUTTON_EXTRA .= '"Storia".<br>';
}
//$LNG->STORY_HOME_BUTTON_EXTRA .= '<span id="storyhomemorebutton" class="active" style="font-weight:normal;text-decoration:underline" onClicca="if ($(\'storyhomemorediv\').style.display == \'none\') { $(\'storyhomemorediv\').style.display = \'block\'; $(\'storyhomemorebutton\').innerHTML = \'read less\'; } else { $(\'storyhomemorediv\').style.display = \'none\';  $(\'storyhomemorebutton\').innerHTML = \'keep reading\';}">keep reading</span></p>';
$LNG->STORY_HOME_BUTTON_EXTRA .= '<div id="storyhomemorediv" style="float:left;clear:both;width:100%;display:block;margin:0px;padding:0px">';
$LNG->STORY_HOME_BUTTON_EXTRA .= 'A ';
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->STORY_HOME_BUTTON_EXTRA .= 'Professionista/Ricercatore';
}
$LNG->STORY_HOME_BUTTON_EXTRA .= ' La storia è costruita fornendo risposte alle seguenti domande:<br>';
$LNG->STORY_HOME_BUTTON_EXTRA .= '<ul>';
$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quale '.$LNG->ISSUE_NAME.' stai indagando?</li>';
$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quale '.$LNG->CHALLENGE_NAME.' affronta?</li>';
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quali proposte stai promuovendo?</li>';
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quale '.$LNG->EVIDENCE_NAME.' a supporto di questa proposta?</li>';
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM === FALSE) {
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quale '.$LNG->SOLUTION_NAME.' è stata o può essere promossa?</li>';
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quale '.$LNG->EVIDENCE_NAME.' a supporto di questa '.$LNG->SOLUTION_NAME.'?</li>';
}
if ($CFG->HAS_CLAIM && $CFG->HAS_SOLUTION === FALSE) {
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quale '.$LNG->CLAIM_NAME.' è stata o può essere formulata?</li>';
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quale '.$LNG->EVIDENCE_NAME.' esiste a supporto di questa'.$LNG->CLAIM_NAME.'?</li>';
}
$LNG->STORY_HOME_BUTTON_EXTRA .= '<li>Quale '.$LNG->RESOURCES_NAME.' puoi aggiungere a supporto di questa '.$LNG->EVIDENCE_NAME.'?</li>';
$LNG->STORY_HOME_BUTTON_EXTRA .= '</ul>';
$LNG->STORY_HOME_BUTTON_EXTRA .= "<p>Gli utenti possono inserire una storia cliccando su 'Aggiungi'";


if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<a id="pstoryaddhomelink" href="javascript:loaddialog(\'createpractitionerstory\',\''.$CFG->homeAddress.'ui/popups/quickformpractitioner.php\', 750,500);" title="Aggiungi la tua storia di praticante"> la tua storia di praticante</a> o aggiungi una <a id="rstoryaddhomelink" href="javascript:loaddialog(\'createreseacherstory\',\''.$CFG->homeAddress.'ui/popups/quickformresearcher.php\', 750,500);" title="Aggiungi la tua storia di ricerca"> Storia del ricercatore</a>.</p>';
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM === FALSE) {
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<a id="pstoryaddhomelink" href="javascript:loaddialog(\'createpractitionerstory\',\''.$CFG->homeAddress.'ui/popups/quickformpractitioner.php\', 750,500);" title="Aggiungi la tua storia"> Storia</a>.</p>';
}
if ($CFG->HAS_CLAIM && $CFG->HAS_SOLUTION === FALSE) {
	$LNG->STORY_HOME_BUTTON_EXTRA .= '<a id="rstoryaddhomelink" href="javascript:loaddialog(\'createreseacherstory\',\''.$CFG->homeAddress.'ui/popups/quickformresearcher.php\', 750,500);" title="Aggiungi la tua storia"> Storia</a>.</p>';
}

$LNG->STORY_HOME_BUTTON_EXTRA .= '</div>';

// Challenge Button
$LNG->CHALLENGE_HOME_BUTTON_EXTRA = "<p>La comunità può usare la ".$LNG->CHALLENGES_NAME." come domande ombrello comuni per raggruppare le questioni che aggiungono all'Evidence Hub.</p>";
$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= '<p>'.$LNG->CHALLENGES_NAME.' può essere utilizzato anche per raggruppare progetti e organizzazioni sotto i problemi comuni che affrontano.</p>';
$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= '<p>Infine la comunità può anche contribuire alla descrizione generale di una'.$LNG->CHALLENGE_NAME.' aggiungendo una risorsa web.<br>';
//$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= '<span id="challengehomemorebutton" class="active" style="font-weight:normal;text-decoration:underline" onClicca="if ($(\'challengehomemorediv\').style.display == \'none\') { $(\'challengehomemorediv\').style.display = \'block\'; $(\'challengehomemorebutton\').innerHTML = \'read less\'; } else { $(\'challengehomemorediv\').style.display = \'none\';  $(\'challengehomemorebutton\').innerHTML = \'keep reading\';}">continua a leggere</span></p>';
$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= '<div id="challengehomemorediv" style="float:left;clear:both;width:100%;display:block;margin:0px;padding:0px">';
$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= $LNG->CHALLENGES_NAME." sono identificati dal team del ".$CFG->SITE_TITLE.", attraverso l'analisi dei dati nell'Evidence Hub e in consultazione con i principali ricercatori e professionisti della comunità. Possono essere esplorati sotto il tab. (collegamento ipertestuale alla scheda)";
$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= "<p>".$LNG->CHALLENGES_NAME." costituiscono un buon punto di partenza per esplorare le ".$LNG->EVIDENCE_NAME." nell'hub.</p>";
$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= '<p>'.$LNG->CHALLENGES_NAME.' può essere esplorata cliccando sulla lista <a href="'.$CFG->homeAddress.'#challenge-list" title="Clicca per andare alla lista delle '.$LNG->CHALLENGES_NAME.' ">'.$LNG->CHALLENGES_NAME.'</a> tab.</p>';
$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= "<p>Nella lista delle ".$LNG->CHALLENGES_NAME.", ".$LNG->CHALLENGES_NAME." possono essere valutate come più o meno rilevanti, così che la comunità degli utenti possa esprimere quanto si considera ciascuna ".$LNG->CHALLENGE_NAME." rispetto alle altre ".$LNG->CHALLENGES_NAME."della lista La freccia verde in su/la freccia rossa in giù possono essere usate per supportare/osteggiare una ".$LNG->CHALLENGES_NAME." nella lista. </p>";
$LNG->CHALLENGE_HOME_BUTTON_EXTRA .= '</div>';

/** TAB INFO HINTS **/
// Challenge Tab
$LNG->CHALLENGE_TAB_INFO_HINT = '<ul style="padding-left:20px;margin-left:0px">';
$LNG->CHALLENGE_TAB_INFO_HINT .= '<li>'.$LNG->CHALLENGES_NAME.' sono state identificate.</li>';
$LNG->CHALLENGE_TAB_INFO_HINT .= "<li>Queste".$LNG->CHALLENGES_NAME." costituiscono un buon punto di partenza per esplorare le prove nell'hub.</li>";
$LNG->CHALLENGE_TAB_INFO_HINT .= '<li>Aiuta la comunità collegando le '.$LNG->CHALLENGES_NAME.' e '.$LNG->ISSUES_NAME.', e '.$LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.'.</li>';
$LNG->CHALLENGE_TAB_INFO_HINT .= '<li>Le '.$LNG->CHALLENGES_NAME.' possono essere valutate come più o meno rilevanti, così che la comunità degli utenti possa esprimere quanto si considera ciascuna '.$LNG->CHALLENGE_NAME.'.</li>';
$LNG->CHALLENGE_TAB_INFO_HINT .= "<li>Se hai effettuato l'accesso, usa la freccia verde in su/la freccia rossa in giù ";
$LNG->CHALLENGE_TAB_INFO_HINT .= '<img border="0" src="'.$HUB_FLM->getImagePath('thumb-up-empty3.png').'"/> <img border="0" src="'.$HUB_FLM->getImagePath('thumb-down-empty3.png').'"/> per supportare/osteggiare una'.$LNG->CHALLENGES_NAME.'.</li>';
$LNG->CHALLENGE_TAB_INFO_HINT .= '</ul>';
// Issue Tab
$LNG->ISSUE_TAB_INFO_HINT = '<ul style="padding-left:20px;margin-left:0px">';
$LNG->ISSUE_TAB_INFO_HINT .= '<li>'.$LNG->ISSUES_NAME.' e i problemi che si devono affrontare si trovano qui.</li>';
$LNG->ISSUE_TAB_INFO_HINT .= '<li>'.$LNG->ISSUES_NAME.' possono essere associati a '.$LNG->CHALLENGES_NAME.' che sono usati per raggruppare le '.$LNG->ISSUES_NAME.' in pochi '.$LNG->CHALLENGES_NAME.'. Clicca la <span class="active">'.$LNG->CHALLENGES_NAME.'</span> tab  per esplorare ulteriormente.</li>';
$LNG->ISSUE_TAB_INFO_HINT .= '<li>'.$LNG->ISSUES_NAME.' sono taggate per '.$LNG->THEMES_NAME.', il che significa che puoi vedere come si relazionano tra loro.</li>';
$LNG->ISSUE_TAB_INFO_HINT .= '<li>Puoi anche vedere quale '.$LNG->ORGS_NAME.' sono interessate a questa '.$LNG->ISSUES_NAME.'.</li>';
$LNG->ISSUE_TAB_INFO_HINT .= '<li>Le '.$LNG->ISSUES_NAME.' esistenti possono essere valutate come più o meno rilevanti, così che la comunità degli utenti possa esprimere quanto si considera rilevante ciascuna '.$LNG->ISSUE_NAME.'.</li>';
$LNG->ISSUE_TAB_INFO_HINT .= "<li>Se hai effettuato l'accesso, usa la freccia verde in su/la freccia rossa in giù ";
$LNG->ISSUE_TAB_INFO_HINT .= '<img border="0" src="'.$HUB_FLM->getImagePath('thumb-up-empty3.png').'"/> <img border="0" src="'.$HUB_FLM->getImagePath('thumb-down-empty3.png').'"/> per supportare/osteggiare una '.$LNG->ISSUES_NAME.'.</li>';
$LNG->ISSUE_TAB_INFO_HINT .= "<li>Se hai effettuato l'accesso, aggiungi la tua ".$LNG->ISSUES_NAME." cliccando 'Aggiungi un ".$LNG->ISSUE_NAME."' - aprendo un dialogo dove puoi inserire una nuova ".$LNG->ISSUE_NAME.".</li>";
$LNG->ISSUE_TAB_INFO_HINT .= "</ul>";
// Solution Tab
$LNG->SOLUTION_TAB_INFO_HINT = '<ul style="padding-left:20px;margin-left:0px">';
$LNG->SOLUTION_TAB_INFO_HINT .= '<li>Qui puoi esplorare le possibili risposte a'.$LNG->ISSUES_NAME.'.</li>';
$LNG->SOLUTION_TAB_INFO_HINT .= '<li>'.$LNG->ISSUES_NAME.' e '.$LNG->SOLUTIONS_NAME.' sono collegati tra loro, quindi puoi vedere queste relazioni.</li>';
$LNG->SOLUTION_TAB_INFO_HINT .= '<li>Vedi le '.$LNG->EVIDENCE_NAME.' associate alle '.$LNG->SOLUTIONS_NAME.' per te esplorando gli elementi pertinenti.</li>';
$LNG->SOLUTION_TAB_INFO_HINT .= '<li>Le '.$LNG->SOLUTIONS_NAME.'esistenti possono essere valutate come più o meno rilevanti, così che la comunità degli utenti possa esprimere quanto si considera rilevante ciascuna  '.$LNG->SOLUTION_NAME.'.</li>';
$LNG->SOLUTION_TAB_INFO_HINT .= "<li>Se hai effettuato l'accesso, usa la freccia verde in su/la freccia rossa in giù ";
$LNG->SOLUTION_TAB_INFO_HINT .= '<img border="0" src="'.$HUB_FLM->getImagePath('thumb-up-empty3.png').'"/> <img border="0" src="'.$HUB_FLM->getImagePath('thumb-down-empty3.png').'"/> per supportare/osteggiare una'.$LNG->SOLUTIONS_NAME.'.</li>';
$LNG->SOLUTION_TAB_INFO_HINT .= "<li>Se hai effettuato l'accesso, aggiungi la tua ".$LNG->SOLUTIONS_NAME." cliccando 'Aggiungi un ".$LNG->SOLUTION_NAME."' - aprendo un dialogo dove puoi inserire una nuova ".$LNG->SOLUTION_NAME.".</li>";

$LNG->SOLUTION_TAB_INFO_HINT .= '</ul>';
// Claim
$LNG->CLAIM_TAB_INFO_HINT = '<ul style="padding-left:20px;margin-left:0px">';
$LNG->CLAIM_TAB_INFO_HINT .= '<li>Clicca sulle singole'.$LNG->CLAIMS_NAME.' per esplorare al '.$LNG->CLAIM_NAME.' in dettaglio - Clicca, poi seleziona\'esplora\'.</li>';
$LNG->CLAIM_TAB_INFO_HINT .= '<li>Ordina e/o filtra le '.$LNG->CLAIMS_NAME.'... puoi anche utilizzare la funzione di ricerca per esplorare.</li>';
$LNG->CLAIM_TAB_INFO_HINT .= "<li>Se hai effettuato l'accesso, aggiungi la tua ".$LNG->CLAIMS_NAME." cliccando 'Aggiungi un ".$LNG->CLAIM_NAME."' - aprendo un dialogo dove puoi inserire una nuova ".$LNG->CLAIM_NAME.".</li>";
$LNG->CLAIM_TAB_INFO_HINT .= '</ul>';

$LNG->EVIDENCE_TAB_INFO_HINT = '<ul style="padding-left:20px;margin-left:0px">';
$LNG->EVIDENCE_TAB_INFO_HINT .= '<li>Le '.$LNG->EVIDENCES_NAME.' esistenti possono essere valutate come più o meno rilevanti, così che la comunità degli utenti possa esprimere quanto si considera rilevante ciascuna '.$LNG->EVIDENCE_NAME.'.</li>';
$LNG->EVIDENCE_TAB_INFO_HINT .= "<li>usa la freccia verde in su/la freccia rossa in giù ";
$LNG->EVIDENCE_TAB_INFO_HINT .= '<img border="0" src="'.$HUB_FLM->getImagePath('thumb-up-empty3.png').'"/> <img border="0" src="'.$HUB_FLM->getImagePath('thumb-down-empty3.png').'"/> ';
$LNG->EVIDENCE_TAB_INFO_HINT .= "per sostenere/osteggiare l'affermazione.</li>";
$LNG->EVIDENCE_TAB_INFO_HINT .= '<li>cliccando on \'Aggiungi un '.$LNG->EVIDENCE_NAME.'\' (appena sotto il menu della scheda orizzontale) puoi contribuire con i tuoi metadati e '.$LNG->RESOURCES_NAME.' su '.$LNG->EVIDENCE_NAME.'.</li>';
$LNG->EVIDENCE_TAB_INFO_HINT .= '<li>Il dialogo permette di descrivere la'.$LNG->EVIDENCE_NAME.', connessa a questo '.$LNG->THEMES_NAME.' e '.$LNG->RESOURCES_NAME.' per supportare la tua '.$LNG->EVIDENCE_NAME.'.</li>';
$LNG->EVIDENCE_TAB_INFO_HINT .= '<li>Cerca di aggiungere una <span class="active">'.$LNG->RESOURCES_NAME.'</span> web per supportare la tua '.$LNG->EVIDENCE_NAME.'.</li>';
$LNG->EVIDENCE_TAB_INFO_HINT .= '</ul>';

$LNG->TAB_RESOURCE_INFO_HINT = '<ul style="padding-left:20px;margin-left:0px">';
$LNG->TAB_RESOURCE_INFO_HINT .= "<li>Quest'area contiene una raccolta di siti Web e pubblicazioni.</li>";
$LNG->TAB_RESOURCE_INFO_HINT .= '<li>Puoi ordinarli e cercarli così come aggiungerne di tuoi.</li>';
$LNG->TAB_RESOURCE_INFO_HINT .= "<li>Clicca sul titolo e poi su 'explore' per aprire i dettagli dell'elemento per quella voce.</li>";
$LNG->TAB_RESOURCE_INFO_HINT .= '<li>La pagina di esplorazione della'.$LNG->RESOURCE_NAME.' mostrerà tutti i relativi'.$LNG->ORGS_NAME.'.'.$LNG->PROJECTS_NAME.', '.$LNG->THEMES_NAME.', e '.$LNG->EVIDENCE_NAME.'.</li>';
$LNG->TAB_RESOURCE_INFO_HINT .= '</ul>';

$LNG->TAB_ORG_INFO_HINT = '<ul style="padding-left:20px;margin-left:0px">';
$LNG->TAB_ORG_INFO_HINT .= '<li>Da questa pagina, se hai effettuato l\'accesso, puoi cliccare su \'Aggiungi un '.$LNG->ORG_NAME.'\' (appena sotto il menu della scheda orizzontale).</li>';
$LNG->TAB_ORG_INFO_HINT .= '<li>Aggiungi una descrizione del'.$LNG->ORG_NAME.', compresa la posizione geografica e il sito web.</li>';
$LNG->TAB_ORG_INFO_HINT .= '<li>Usa <span class="active">Geo Map View</span> e <span class="active">'.$LNG->THEME_NAME.' Map View</span> per esplorare '.$LNG->ORGS_NAME.' in relazione gli uni agli altri.</li>';
$LNG->TAB_ORG_INFO_HINT .= '</ul>';

$LNG->TAB_PROJECT_INFO_HINT = '<ul style="padding-left:20px;margin-left:0px">';
$LNG->TAB_PROJECT_INFO_HINT .= '<li>Da questa pagina, se hai effettuato l\'accesso, puoi cliccare su \'Aggiungi un '.$LNG->PROJECT_NAME.'\' (appena sotto il menu della scheda orizzontale).</li>';
$LNG->TAB_PROJECT_INFO_HINT .= '<li>Aggiungi una descrizione del tuo '.$LNG->PROJECTS_NAME.', compresa la posizione geografica e il sito web.</li>';
$LNG->TAB_PROJECT_INFO_HINT .= '<li>Usa <span class="active">Geo Map View</span> e <span class="active">'.$LNG->THEME_NAME.' Map View</span> per esplorare'.$LNG->PROJECTS_NAME.' in relazione gli uni agli altri.</li>';
$LNG->TAB_PROJECT_INFO_HINT .= '</ul>';

$LNG->TAB_USER_INFO_HINT = '<p style="padding: 5px; margin-top:0;">L\'Evidence Hub è un\'intelligenza collettiva guidata dalla comunità: solleva le tue domande, proponi soluzioni, aggiungi prove per beneficiare davvero di questa risorsa!</p>';

if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
	$LNG->TAB_USER_INFO_HINT .= '<p style="padding: 5px; margin-top:0px">Per iniziare a contribuire per favore crea un account</p>';
	$LNG->TAB_USER_INFO_HINT .= '<ul style="padding-left:20px;margin-left:0px">';
	$LNG->TAB_USER_INFO_HINT .= '<li>Clicca su Iscriviti in alto a destra della homepage.</li>';
	$LNG->TAB_USER_INFO_HINT .= '<li>Compila il modulo (incluso il captcha) e richiedi il tuo account.</li>';
	$LNG->TAB_USER_INFO_HINT .= '<li>Una volta registrato, accedi e personalizza il tuo profilo cliccando sul nome del tuo account.</li>';
	$LNG->TAB_USER_INFO_HINT .= '</ul>';
} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
	$LNG->TAB_USER_INFO_HINT .= '<p style="padding: 5px; margin-top:0px">Per iniziare a contribuire per favore crea un account</p>';
	$LNG->TAB_USER_INFO_HINT .= '<ul style="padding-left:20px;margin-left:0px">';
	$LNG->TAB_USER_INFO_HINT .= '<li>Clicca su Iscriviti in alto a destra della homepage.</li>';
	$LNG->TAB_USER_INFO_HINT .= '<li>Compila il modulo (incluso il captcha) e richiedi il tuo account.</li>';
	$LNG->TAB_USER_INFO_HINT .= '<li>Riceverai una notifica via e-mail quando il tuo account diventa attivo</li>';
	$LNG->TAB_USER_INFO_HINT .= '<li>Una volta registrato, accedi e personalizza il tuo profilo cliccando sul nome del tuo account.</li>';
	$LNG->TAB_USER_INFO_HINT .= '</ul>';
} else {
	$LNG->TAB_USER_INFO_HINT .= '<p style="padding-left: 5px; margin-top:0px">iscrizione per questo sito è attualmente solo su invito.</p>';
}

/**** EMAIL TEXT *****/
$LNG->WELCOME_REGISTER_OPEN_SUBJECT = "Benvenuto su ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_OPEN_BODY = 'Grazie per esserti iscritto<br><br>Per ulteriori informazioni su cos\'è l\'Evidence Hub, leggi il nostro<a href="'.$CFG->homeAddress.'ui/pages/about.php">about page</a>.<br>Per assistenza su come iniziare a utilizzare l\'hub, perché visita il nostro <a href="'.$CFG->homeAddress.'help/">pagina di aiuto</a>.<br>Inizia a usare il nostro <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a> oggi stesso.';

$LNG->VALIDATE_REGISTER_SUBJECT = "Completa l'iscrizione ".$CFG->SITE_TITLE;

$LNG->WELCOME_REGISTER_REQUEST_SUBJECT = "Richiedi di iscriverti a ".$CFG->SITE_TITLE;
$LNG->WELCOME_REGISTER_REQUEST_BODY = 'Grazie per aver richiesto un account su <a href="'.$CFG->homeAddress.'">'.$CFG->SITE_TITLE.'</a>.<br>Abbiamo ricevuto la tua richiesta.<br>Cercheremo di elaborare la tua richiesta entro 24 ore, ma nei periodi di maggiore affluenza potrebbe essere necessario più tempo.<br>Riceverai un\'ulteriore email con i tuoi dati di accesso, se la tua richiesta è andata a buon fine.<br><br>Grazie ancora per il tuo interesse.';
$LNG->WELCOME_REGISTER_REQUEST_BODY_ADMIN = "Un nuovo utente ha richiesto un account. Per favore usa l'area di amministrazione per accettare o rifiutare questo nuovo utente.";

$LNG->WELCOME_REGISTER_CLOSED_SUBJECT = "Iscrizione su".$CFG->SITE_TITLE;

$LNG->MAILCHIMP_SUBSCRIPTION_ERROR_SUBJECT = "Problemi ad iscriversi a MailChimp ";
$LNG->MAILCHIMP_SUBSCRIPTION_ERROR_BODY = "Problemi nel tentativo di iscrivere un nuovo utente a MailChimp";
$LNG->MAILCHIMP_EDIT_ERROR_SUBJECT = "Problema a modificare MailChimp";
$LNG->MAILCHIMP_EDIT_ERROR_BODY = "Problemi nel tentativo di modificare un  utente su MailChimp";
$LNG->MAILCHIMP_UNSUBSCRIBE_ERROR_SUBJECT = "Problemi ad annullare l\'iscrizione a MailChimp";
$LNG->MAILCHIMP_UNSUBSCRIBE_ERROR_BODY = "Problemi nel tentativo annullare l\'iscrizione a MailChimp";
$LNG->MAILCHIMP_SUBSCRIBER_LIST_ERROR = 'Impossibile caricare l\'elenco degli iscritti!';
$LNG->MAILCHIMP_UPDATE_MEMBER_ERROR = 'Impossibile aggiornare le informazioni sui membri!';
$LNG->MAILCHIMP_CHECK_MEMBERS_ERROR = 'Impossibile controllare i membri!';

/*** NODE nelle listeS AND ITEMS ***/
$LNG->NODE_DETAIL_BUTTON_TEXT = 'Dettagli completi';
$LNG->NODE_DETAIL_MENU_TEXT = 'Dettagli completi';

//$LNG->NODE_DETAIL_BUTTON_HINT = 'Clicca per visualizzare tutte le informazioni e i collegamenti su questo elemento.';
//$LNG->NODE_DETAIL_BUTTON_HINT = 'Vai all\'elemento e visualizzare tutte le informazioni';

$LNG->NODE_DETAIL_BUTTON_HINT = 'Visualizza le informazioni su questo elemento.';

$LNG->NODE_MAP_BUTTON_TEXT = 'Grafico di rete';
$LNG->NODE_MAP_BUTTON_HINT = 'Vedi il grafico di rete  su questo elemento (utilizza un\'applet Java)';
$LNG->NODE_TYPE_ICON_HINT = 'Visualizza l\'immagine originale';
$LNG->NODE_EXPLORE_BUTTON_TEXT = 'Esplora >>';
$LNG->NODE_EXPLORE_BUTTON_HINT = 'Clicca su Mostra/Nascondi per visualizzare più informazioni e attività su questo elemento';
$LNG->NODE_DISCONNECT_MENU_TEXT = 'Disconnetti';
$LNG->NODE_DISCONNECT_MENU_HINT = 'Disconnettilo dall\'elemento focale corrente';
$LNG->NODE_DISCONNECT_LINK_TEXT = 'Rimuovi';
$LNG->NODE_DISCONNECT_LINK_HINT = 'Disconnettilo dall\'elemento focale corrente';
$LNG->NODE_TOGGLE_HINT = 'Clicca per visualizzare/nascondere ulteriori informazioni';
$LNG->NODE_VIEW_CONNECTOR_MENU_TEXT = "Chi l\'ha collegato?";
$LNG->NODE_VIEW_CONNECTOR_MENU_HINT = "Vai alla Home Page del connettore: ";

//in widget list
$LNG->NODE_RELEVANCE_ADD_ICON_ALT = 'Rilevanza';
$LNG->NODE_RELEVANCE_ADD_ICON_HINT = 'Aggiungi perché questa è un\'associazione rilevante al nodo focale';
$LNG->NODE_RELEVANCE_EDIT_LINK_TEXT = 'Modifica Rilevanza';
$LNG->NODE_RELEVANCE_EDIT_LINK_HINT = 'Modifica il testo che hai inserito sul motivo per cui questa è un\'associazione rilevante al nodo focale';

$LNG->NODE_RELEVANCE_VIEW_MENU_TEXT = 'Visualizza rilevanza';
$LNG->NODE_RELEVANCE_VIEW_MENU_HINT = 'Scopri perché questa è un\'associazione pertinente a quanto sopra';
$LNG->NODE_RELEVANCE_HEADING = 'Rilevanza';
$LNG->NODE_RELEVANCE_ADD_MENU_TEXT = 'Aggiungi rilevanza';
$LNG->NODE_RELEVANCE_EDIT_MENU_TEXT = 'Modifica rilevanza ';

$LNG->NODE_EDIT_ICON_ALT = 'Modifica';
$LNG->NODE_EDIT_CHALLENGE_ICON_HINT = 'Modifica questa '.$LNG->CHALLENGE_NAME;
$LNG->NODE_EDIT_ISSUE_ICON_HINT = 'Modifica questa '.$LNG->ISSUE_NAME;
$LNG->NODE_EDIT_SOLUTION_ICON_HINT = 'Modifica questa '.$LNG->SOLUTION_NAME;
$LNG->NODE_EDIT_CLAIM_ICON_HINT = 'Modifica questa '.$LNG->CLAIM_NAME;
$LNG->NODE_EDIT_EVIDENCE_ICON_HINT = 'Modifica questa '.$LNG->EVIDENCE_NAME;
$LNG->NODE_EDIT_RESOURCE_ICON_HINT = 'Modifica questa '.$LNG->RESOURCE_NAME;
$LNG->NODE_EDIT_PROJECT_ICON_HINT = 'Modifica questo '.$LNG->PROJECT_NAME;
$LNG->NODE_EDIT_ORG_ICON_HINT = 'Modifica questo '.$LNG->ORG_NAME;

$LNG->NODE_DELETE_ICON_ALT = 'Cancella';
$LNG->NODE_DELETE_ICON_HINT = 'Cancella questo elemento';
$LNG->NODE_NO_DELETE_ICON_ALT = 'Non è possibile cancellare';
$LNG->NODE_NO_DELETE_ICON_HINT = 'Non puoi cancellare questo elemento. Qualcun altro si è collegato ad esso';
$LNG->NODE_SUPPORTING_EVIDENCE_LINK = 'A favore '.$LNG->EVIDENCE_NAME;
$LNG->NODE_ADD_SUPPORTING_EVIDENCE_HINT = 'Aggiungi una '.$LNG->EVIDENCE_NAME.'a favore';
$LNG->NODE_COUNTER_EVIDENCE_LINK = 'Contro '.$LNG->EVIDENCE_NAME;
$LNG->NODE_ADD_COUNTER_EVIDENCE_HINT = 'Aggiungi una '.$LNG->EVIDENCE_NAME.'contro';

$LNG->NODE_VOTE_FOR_ICON_ALT = 'Vota per';
$LNG->NODE_VOTE_AGAINST_ICON_ALT = 'Vota contro';
$LNG->NODE_VOTE_REMOVE_HINT = 'Cancella il setting...';
$LNG->NODE_VOTE_FOR_ADD_HINT = 'Supporta questo...';
$LNG->NODE_VOTE_FOR_SOLUTION_HINT = $LNG->SOLUTION_NAME.' forte per questo';
$LNG->NODE_VOTE_FOR_CLAIM_HINT = $LNG->CLAIM_NAME.' robusta er questo';
$LNG->NODE_VOTE_FOR_EVIDENCE_SOLUTION_HINT = $LNG->EVIDENCE_NAME.' convincente per questo';
$LNG->NODE_VOTE_FOR_EVIDENCE_CLAIM_HINT = $LNG->EVIDENCE_NAME.' robusto per questo';
$LNG->NODE_VOTE_AGAINST_ADD_HINT = 'osteggia...';
$LNG->NODE_VOTE_AGAINST_SOLUTION_HINT = $LNG->SOLUTION_NAME.' debole per questo';
$LNG->NODE_VOTE_AGAINST_CLAIM_HINT = $LNG->CLAIM_NAME.' non robusta per questo';
$LNG->NODE_VOTE_AGAINST_EVIDENCE_SOLUTION_HINT = $LNG->EVIDENCE_NAME.' non convincente per questo';
$LNG->NODE_VOTE_AGAINST_EVIDENCE_CLAIM_HINT = $LNG->EVIDENCE_NAME.' non robusta per questo';
$LNG->NODE_VOTE_FOR_LOGIN_HINT = 'Accedi per promuovere questo';
$LNG->NODE_VOTE_AGAINST_LOGIN_HINT = 'Accedi per osteggiare questo';
$LNG->NODE_VOTE_MENU_TEXT = 'Vota:';

$LNG->NODE_ADDED_ON = 'aggiunto il:';
$LNG->NODE_ADDED_BY = 'aggiunto da:';
$LNG->NODE_CONNECTED_ON = 'Connesso su';
$LNG->NODE_CONNECTED_BY = 'Connesso da';
$LNG->NODE_RESOURCE_LINK_HINT = 'Vai al sito';
$LNG->NODE_URL_LINK_TEXT = 'Vai alla pagina web';
$LNG->NODE_URL_LINK_HINT = 'Apri la pagina associata in una tab';
$LNG->NODE_URL_HEADING = 'Url:';
$LNG->NODE_RESOURCE_CLIPS_HEADING = 'Clips:';
$LNG->NODE_TAGS_HEADING = 'Tags:';
$LNG->NODE_DESC_HEADING = 'Descrizione';
$LNG->NODE_SHARED_THEMES = $LNG->THEMES_NAME.' condivisi: ';

$LNG->NODE_CHILDREN_ISSUE = 'Sub '.$LNG->ISSUES_NAME;
$LNG->NODE_CHILDREN_SOLUTION = $LNG->SOLUTIONS_NAME.' a questo';
$LNG->NODE_CHILDREN_CLAIM = $LNG->CLAIMS_NAME.' che risponde a questo';
$LNG->NODE_CHILDREN_EVIDENCE_PRO = $LNG->EVIDENCES_NAME.' a favore';
$LNG->NODE_CHILDREN_EVIDENCE_CON = $LNG->EVIDENCES_NAME.' contro';
$LNG->NODE_CHILDREN_RESOURCES =  $LNG->RESOURCES_NAME;

$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART1 = 'Sei sicuro di disconnetterti';
$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART2 = 'da';
$LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART3 = '?';
$LNG->NODE_DELETE_CHECK_MESSAGE = 'Sei sicuro di voler cancellare';
$LNG->NODE_DELETE_CHECK_MESSAGE_ITEM = 'item';
$LNG->NODE_FOLLOW_ITEM_HINT = 'Segui questo elemento...';
$LNG->NODE_UNFOLLOW_ITEM_HINT = 'Non seguire più questo elemento...';
$LNG->NODE_CONNECTION_RELEVANCE_MESSAGE = 'Perché questa associazione è rilevante?';

/** Geographical Maps **/
$LNG->GEO_LOADING = 'Caricamento mappa';
$LNG->GEO_BROWSER_INCOMPATIBLE = 'Browser incompatibile';
$LNG->GEO_LOADING_ERROR = 'Si è verificato un errore durante il caricamento dei dati della mappa';
$LNG->GEO_LOADING_ERROR_FAILURE = 'Errore nel caricamento della mappa...';
$LNG->GEO_ORG_LOADING = '(Sta caricando la localizzazione del '.$LNG->ORG_NAME.'...)';
$LNG->GEO_PROJECT_LOADING = '(Sta caricando la localizzazione del '.$LNG->PROJECT_NAME.' ...)';
$LNG->GEO_USER_LOADING = '(Sta caricando la localizzazione dell\'utente...)';
$LNG->GEO_USER_NODE_LOADING = '(Sta caricando la posizione di ingresso dell\'utente...)';

/** Mappa di reteS **/
$LNG->NETWORKMAPS_RESIZE_MAP_HINT = 'Ridimensiona la mappa';
$LNG->NETWORKMAPS_ENLARGE_MAP_LINK = 'ingrandisci la mappa';
$LNG->NETWORKMAPS_REDUCE_MAP_LINK = 'Rimpicciolisci la mappa';
$LNG->NETWORKMAPS_EXPLORE_ITEM_LINK = 'Esplora l\'elemento selezionato';
$LNG->NETWORKMAPS_EXPLORE_ITEM_HINT = 'Apri la pagine per visualizzare i dettagli completi dell\'elemento selezionato';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_LINK = 'Esplora l\'autore dell\'elemento selezionato';
$LNG->NETWORKMAPS_EXPLORE_AUTHOR_HINT = 'Apri la home page dell\'autore per l\'elemento attualmente selezionato';
$LNG->NETWORKMAPS_SELECTED_NODEID_ERROR = 'Per favore assicurati di aver effettuato una selezione nella mappa.';
$LNG->NETWORKMAPS_MAC_PAINT_ISSUE_WARNING = '(Questa visualizzazione richiede Java 7 su MacOS X 10.7 in poi (Lion) per funzionare correttamente)';
$LNG->NETWORKMAPS_APPLET_NOT_RECOGNISED_ERROR = '(Il tuo browser riconosce l\'elemento APPLET ma non esegue l\'applet.)';
$LNG->NETWORKMAPS_THEME_SELECTION_MESSAGE = 'Per favore fai una selezione sopra per visualizzare una mappa';
$LNG->NETWORKMAPS_LOADING_MESSAGE = '(Caricamento mappa...)';
$LNG->NETWORKMAPS_APPLET_REF_BROKEN_ERROR = 'Riferimento all\'applet della mappa interrotto. Per favore riavvia il browser.';
$LNG->NETWORKMAPS_NO_RESULTS_THEME_MESSAGE = 'Nessun risultato trovato. per favore seleziona di nuovo.';
$LNG->NETWORKMAPS_NO_RESULTS_MESSAGE = 'Nessun risultato trovato. per favore seleziona di nuovo.';
$LNG->NETWORKMAPS_SAME_USER_MESSAGE = 'Tutti i collegamenti effettuati dalla stessa persona.';
$LNG->NETWORKMAPS_OPTIONAL_TYPE = 'e facoltativamente un tipo';
$LNG->NETWORKMAPS_KEY_SELECTED_ITEM = 'Seleziona elemento';
$LNG->NETWORKMAPS_KEY_FOCAL_ITEM = 'elemento focale';
$LNG->NETWORKMAPS_KEY_NEIGHBOUR_ITEM = 'elemento vicino';
$LNG->NETWORKMAPS_KEY_SOCIAL_MODERATELY = 'moderatamente connesso';
$LNG->NETWORKMAPS_KEY_SOCIAL_HIGHLY = 'fortemente connesso';
$LNG->NETWORKMAPS_KEY_SOCIAL_SLIGHTLY = 'scarsamente connesso';
$LNG->NETWORKMAPS_KEY_SOCIAL_MOST = 'Il più connesso';

/** cambia PASSWORD PAGE **/
$LNG->cambia_PASSWORD_TITLE = 'cambia Password';
$LNG->cambia_PASSWORD_CURRENT_PASSWORD_ERROR = 'per favore inserisci la tua password attuale';
$LNG->cambia_PASSWORD_NEW_PASSWORD_ERROR = 'per favore inserisci la tua nuova password';
$LNG->cambia_PASSWORD_CONFIRM_PASSWORD_ERROR = 'per favore conferma la tua password';
$LNG->cambia_PASSWORD_PASSWORD_INCORRECT_ERROR = 'La tua password attuale non è corretta. per favore  riprova.';
$LNG->cambia_PASSWORD_CONFIRM_MISSMATCH_ERROR = "La password e la conferma della password non corrispondono.";
$LNG->cambia_PASSWORD_PROVIDE_PASSWORD_ERROR = 'Devi inserire una password.';
$LNG->cambia_PASSWORD_SUCCESSFUL_UPDATE = 'Password aggiornata con successo';
$LNG->cambia_PASSWORD_BACK_TO_PROFILE = 'Vai al mio Profilo';
$LNG->cambia_PASSWORD_GO_TO_MY_HOME = 'Vai alla mia Home Page';
$LNG->cambia_PASSWORD_CURRENT_PASSWORD_LABEL = 'Password attuale:';
$LNG->cambia_PASSWORD_NEW_PASSWORD_LABEL = 'Nuova password:';
$LNG->cambia_PASSWORD_CONFIRM_PASSWORD_LABEL = 'Conferma la password:';
$LNG->cambia_PASSWORD_UPDATE_BUTTON = 'Aggiorna';

/** FORGOT PASSWORD PAGE **/
$LNG->FORGOT_PASSWORD_TITLE = 'Hai dimenticato la password?';
$LNG->FORGOT_PASSWORD_HEADER_MESSAGE = "Eer favore inserisci la tua mail e ti invieremo un link dove potrai reimpostare la tua password.";
$LNG->FORGOT_PASSWORD_EMAIL_NOT_FOUND_ERROR = 'Indirizzo mail non trovato';
$LNG->FORGOT_PASSWORD_EMAIL_SUMMARY = 'Reimposta la password';
$LNG->FORGOT_PASSWORD_EMAIL_SENT_MESSAGE = 'È stata inviata una mail per reimpostare la password.';
$LNG->FORGOT_PASSWORD_EMAIL_LABEL = 'Email:';
$LNG->FORGOT_PASSWORD_SUBMIT_BUTTON = 'Inoltra';

/** LOGIN PAGE **/
$LNG->LOGIN_TITLE = 'Accedi a '.$CFG->SITE_TITLE;
$LNG->LOGIN_INVALID_ERROR = 'Accesso non valido, per favore riprova.';
$LNG->LOGIN_NOT_RegistraED_MESSAGE = 'Non sei ancora registrato?';
$LNG->LOGIN_INVITIATION_ONLY_MESSAGE = 'La iscrizione per questo sito è attualmente solo su invito.';
$LNG->LOGIN_SIGNUP_OPEN_LINK = 'Iscriviti!';
$LNG->LOGIN_SIGNUP_REGISTER_LINK = 'Iscriviti!';
$LNG->LOGIN_USERNAME_LABEL = 'Email:';
$LNG->LOGIN_PASSWORD_LABEL = 'Password:';
$LNG->LOGIN_LOGIN_BUTTON = 'Login';
$LNG->LOGIN_FORGOT_PASSWORD_LINK = 'Hai dimenticato la password?';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART1 = 'Hai dimenticato la password? per favore';
$LNG->LOGIN_FORGOT_PASSWORD_MESSAGE_PART2 = 'contattaci';
$LNG->LOGIN_PASSWORD_LENGTH = 'Yla nostra password deve essere lunga almeno 8 caratteri.';
$LNG->LOGIN_PASSWORD_LENGTH_UPDATE = 'Per una maggiore sicurezzaora applichiamo una lunghezza minima della password di 8 caratteri sui nuovi account.<br>Consigliamo ai titolari di account esistenti con password di lunghezza inferiore a 8 caratteri di reimpostare le password ora.<br>Grazie per la vostra collaborazione nell\'aumentare la sicurezza su questo sito.';

/** PROFILE PAGE **/
$LNG->PROFILE_TITLE = 'Modifica Profilo';
$LNG->PROFILE_cambia_PASSWORD_LINK = '(cambia Password)';
$LNG->PROFILE_INVALID_EMAIL_ERROR = "Per favore inserire un indirizzo email valido.";
$LNG->PROFILE_EMAIL_IN_USE_ERROR = "L'indirizzo email è già in uso, per favore selezionane un altro.";
$LNG->PROFILE_FULL_NAME_ERROR = "Per favore inserisci il tuo nome e cognome.";
$LNG->PROFILE_HOMEPAGE_URL_ERROR = "Per favore inserisci un URL valido completo (compreso 'https://') per la tua home page.";
$LNG->PROFILE_SUCCESSFULLY_UPDATED_MESSAGE = 'Profilo aggiornato con successo';
$LNG->PROFILE_UPDATE_BUTTON = 'Aggiorna';
$LNG->PROFILE_DESC_LABEL = 'Descrizione';
$LNG->PROFILE_PHOTO_CURRENT_LABEL = 'Foto attuale:';
$LNG->PROFILE_PHOTO_REPLACE_LABEL = 'Sostituisci foto con:';
$LNG->PROFILE_PHOTO_LABEL = 'Foto:';
$LNG->PROFILE_LOCATION = 'Luogo: (Città)';
$LNG->PROFILE_COUNTRY = 'Paese...';
$LNG->PROFILE_HOMEPAGE = 'Homepage:';
$LNG->PROFILE_EMAIL_VALIDATE_TEXT = 'Validare indirizzo mail';
$LNG->PROFILE_EMAIL_VALIDATE_HINT = 'Il tuo indirizzo mail non è stato validato.';
$LNG->PROFILE_EMAIL_VALIDATE_MESSAGE = 'Ti è stata inviata una mail per confermare che possiedi l\'indirizzo email su questo account utente.';
$LNG->PROFILE_EMAIL_VALIDATE_COMPLETE = 'Questo indirizzo email è stato convalidato.';
$LNG->PROFILE_EMAIL_cambia_CONFIRM = 'Hai cambiato il tuo indirizzo mail.\nQuesto nuovo indirizzo email dovrà essere verificato.\n\nIl tuo account utente sarà ora bloccato, verrai disconnesso e ti verrà inviata una nuova email di convalida dell\'account.\nPer favore clicca sul link nell\'email per completare il cambio di indirizzo email.\n\nSei sicuro di voler procedere?';

/** COMPENDIUM IMPORT **/
$LNG->IMPORT_COMPENDIUM_TITLE = 'Importa da Compendio';
$LNG->IMPORT_COMPENDIUM_HELP_LINK = 'Aiuto';
$LNG->IMPORT_COMPENDIUM_FILE_UPLOAD_ERROR = 'Si è verificato un errore durante il caricamento del file';
$LNG->IMPORT_COMPENDIUM_INVALID_XML = 'Non è un file XML valido';
$LNG->IMPORT_COMPENDIUM_SUCCESS_MESSAGE = 'Il file è stato caricato e importato con successo:';
$LNG->IMPORT_COMPENDIUM_PROBLEMS_ERROR = 'Sono stati riscontrati i seguenti problemi durante il caricamento, per favore  riprova:';
$LNG->IMPORT_COMPENDIUM_FILE_LABEL = 'File XML Compendio:';
$LNG->IMPORT_COMPENDIUM_IMPORT_BUTTON = 'Importa';
$LNG->IMPORT_COMPENDIUM_NO_LINKS_ERROR = 'Non ci sono collegamenti che possono essere importati da questa mappa';
$LNG->IMPORT_COMPENDIUM_CONNECTION_MESSAGE_PART1 = 'Connessione aggiunta da:';
$LNG->IMPORT_COMPENDIUM_CONNECTION_MESSAGE_PART2 = 'a:';
$LNG->IMPORT_COMPENDIUM_IDEA_ADDED_MESSAGE = 'Idea aggiunta:';
$LNG->IMPORT_COMPENDIUM_FORM_MESSAGE = 'Per favore seleziona il file Compendio XML da importare e seleziona uno o più Temi da associare ai dati importati.';
$LNG->IMPORT_COMPENDIUM_THEME_FORM_HINT = '(obbligatorio)- Seleziona almeno un'.$LNG->THEME_NAME.' da associare a tutti i dati che stai importando. Puoi inserirne più di uno.';
$LNG->IMPORT_COMPENDIUM_LOADING_DATA = '( Importazione dei dati del Compendio... Nota: il tempo impiegato varia in base alla dimensione del file di importazione XML )';
$LNG->IMPORT_COMPENDIUM_REQUIRED_FIELDS_MESSAGE_PART1 = '(I campi con un';
$LNG->IMPORT_COMPENDIUM_REQUIRED_FIELDS_MESSAGE_PART2 = 'sono obbligatori)';

/** BUILDER TOOLBAR **/
$LNG->BUILDER_GOTO_HOME_SITE_HINT = "Vai al sito ".$CFG->SITE_TITLE." ";
$LNG->BUILDER_COLLAPSE_TOOLBAR_HINT = "Chiudi l'Aiuto di Evidence Hub";
$LNG->BUILDER_ADD_RESOURCE_HINT = "Aggiungi questa pagina come una nuova ".$LNG->RESOURCE_NAME."";
$LNG->BUILDER_ADD_EVIDENCE_HINT = "Aggiungi una nuova ".$LNG->EVIDENCE_NAME." ";
$LNG->BUILDER_ADD_ISSUE_HINT = "Aggiungi una nuova ".$LNG->ISSUE_NAME."";
$LNG->BUILDER_ADD_SOLUTION_HINT = "Aggiungi una nuova ".$LNG->SOLUTION_NAME." ";
$LNG->BUILDER_ADD_CLAIM_HINT = "Aggiungi una nuova ".$LNG->CLAIM_NAME." ";
$LNG->BUILDER_ADD_ORG_HINT = "Aggiungi una nuova ".$LNG->ORG_NAME."/".$LNG->PROJECT_NAME."";
$LNG->BUILDER_CLOSE_TOOLBAR_HINT = "Chiudi l'Aiuto di Evidence Hub";
$LNG->BUILDER_TITLE_LABEL = "Titolo:";
$LNG->BUILDER_EXPLORE_LINK = "Esplora";

/** FOOTER **/
$LNG->FOOTER_TERMS_LINK = 'Termini di utilizzo';
$LNG->FOOTER_PRIVACY_LINK = 'Privacy';
$LNG->FOOTER_COOKIES_LINK = 'Cookies';
$LNG->FOOTER_CONTACT_LINK = 'Contatti';
$LNG->FOOTER_FAMILY_MESSAGE_PART1 = 'Parte di';
$LNG->FOOTER_FAMILY_MESSAGE_PART2 = 'famiglia';
$LNG->FOOTER_EVIDENCE_HUB_HINT = 'Vai al sito evidence-hub.net';
$LNG->FOOTER_ACCESSIBILITY = 'Accessibilità';

/** REPORT FOOTER **/
$LNG->FOOTER_REPORT_PRINTED_ON = 'Rapporto stampato su:';

/** USERS **/
$LNG->USERS_UNFOLLOW = 'Non seguire più questa persona...';
$LNG->USERS_FOLLOW = 'Segui questa persona...';
$LNG->USERS_FOLLOW_ICON_ALT = 'Segui';
$LNG->USERS_STARTED_FOLLOWING_ON = 'ha iniziato a seguire su:';
$LNG->USERS_PROFILE_TAGS = 'Tag del profilo:';
$LNG->USERS_LAST_LOGIN = 'Ultimo accesso:';
$LNG->USERS_LAST_ACTIVE = 'Ultima attività:';
$LNG->USERS_DATE_JOINED = 'Data di iscrizione:';
$LNG->USERS_PRESENCE_OFF = 'Utente offline o inattivo per più di 20 minuti';
$LNG->USERS_PRESENCE_ON = 'Utente attivo negli ultimi 20 minuti';

/** THEMELIST **/
$LNG->THEMELIST_ITEM_HINT = 'Clicca per esplorare questo';

/** USER HOME PAGE **/
$LNG->USER_HOME_MANAGE_TAGS_LINK = 'Gestisci i Tag';
$LNG->USER_HOME_MANAGE_TAGS_HINT = 'Apri una finestra di dialogo popup che elenca tutti i tuoi tag e ti consente di modificarli/eliminarli e visualizzarne l\'utilizzo.';
$LNG->USER_HOME_IMPORT_COMPENDIUM_LINK = 'Importa da Compendio';
$LNG->USER_HOME_IMPORT_BIBTEX_LINK = 'Importa da Bib TeX';

$LNG->USER_HOME_REMOVE_ACCOUNT_LINK = 'Richiedi la chiusura dell\'account';
$LNG->USER_HOME_REMOVE_ACCOUNT_EMAIL_CONFIRMATION = 'Richiesta di chiusura dell\'account inviata';
$LNG->USER_HOME_REMOVE_ACCOUNT_LINK_HINT = 'Invia una mail per richiedere la chiusura del tuo account';
$LNG->USER_HOME_REMOVE_ACCOUNT_CONFIRM = 'Il tuo account verrà reso anonimo e i tuoi dati personali rimossi, ma i tuoi contenuti sul sito rimarranno.\nUna volta implementata, questa azione non può essere annullata.\n\nSei sicuro di voler richiedere la chiusura del tuo account?';

$LNG->USER_HOME_COMPENDIUM_HELP_LINK = 'Aiuto';
$LNG->USER_HOME_LOCATION_LABEL = 'Luogo:';
$LNG->USER_HOME_TABLE_ITEM_TYPE = 'Tipo di elemento';
$LNG->USER_HOME_TABLE_CREATION_COUNT = 'Creation Count';
$LNG->USER_HOME_TABLE_VIEW = 'Visualizza';
$LNG->USER_HOME_TABLE_TYPE = 'Tipo';
$LNG->USER_HOME_TABLE_NAME = 'Nome';
$LNG->USER_HOME_TABLE_ACTION = 'Azione';
$LNG->USER_HOME_TABLE_PICTURE = 'Immagine';
$LNG->USER_HOME_PROFILE_HEADING = 'Profilo';
$LNG->USER_HOME_VIEW_CONTENT_HEADING = 'Riepilogo creazione contenuti';
$LNG->USER_HOME_VIEW_ACTIVITIES_LINK = "(Visualizza tutte le attività per questa persona)";
$LNG->USER_HOME_VIEW_ACTIVITIES_HINT =  "Si apre una nuova finestra e il caricamento potrebbe richiedere del tempo a seconda del volume di attività di quella persona";
$LNG->USER_HOME_FOLLOWING_HEADING = 'Stai seguendo';
$LNG->USER_HOME_ACTIVITY_ALERT = 'Invia e-mail di avviso di nuova attività';
$LNG->USER_HOME_EMAIL_DAILY = 'Giornalmente';
$LNG->USER_HOME_EMAIL_WEEKLY = 'Settimanalmente';
$LNG->USER_HOME_EMAIL_MONTHLY = 'Mensilmente';
$LNG->USER_HOME_PERSON_LABEL = 'Persona';
$LNG->USER_HOME_UNFOLLOW_LINK = 'Non seguire più';
$LNG->USER_HOME_EXPLORE_LINK = 'Esplora';
$LNG->USER_HOME_ACTIVITY_LINK = 'Attività';
$LNG->USER_HOME_NOT_FOLLOWING_MESSAGE = 'Non segui ancora persone o elementi.';
$LNG->USER_HOME_FOLLOWERS_HEADING = 'Followers';
$LNG->USER_HOME_NO_FOLLOWERS_MESSAGE = 'Ancora nessun follower.';
$LNG->USER_HOME_ANALYTICS_LINK_TEXT = '(Visualizza Analytics per questa persona)';
$LNG->USER_HOME_ANALYTICS_LINK_HINT =  "Si apre una nuova finestra e il caricamento potrebbe richiedere del tempo a seconda del volume di attività di quella persona";

/** MAIN TAB SCREENS - TABBERLIB **/
$LNG->TAB_ADD_CHALLENGE_LINK = 'Aggiungi un '.$LNG->CHALLENGE_NAME;
$LNG->TAB_ADD_ISSUE_LINK = 'Aggiungi una '.$LNG->ISSUE_NAME;
$LNG->TAB_ADD_SOLUTION_LINK = 'Aggiungi una '.$LNG->SOLUTION_NAME;
$LNG->TAB_ADD_CLAIM_LINK = 'Aggiungi un\''.$LNG->CLAIM_NAME; //affermazione - masculine
$LNG->TAB_ADD_EVIDENCE_LINK = 'Aggiungi una '.$LNG->EVIDENCE_NAME;
$LNG->TAB_ADD_RESOURCE_LINK = 'Aggiungi una '.$LNG->RESOURCE_NAME;
$LNG->TAB_ADD_ORG_LINK = 'Aggiungi un '.$LNG->ORG_NAME;
$LNG->TAB_ADD_PROJECT_LINK = 'Aggiungi un '.$LNG->PROJECT_NAME;
$LNG->TAB_ADD_COMMENT_LINK = 'Aggiungi una '.$LNG->COMMENT_NAME;

$LNG->TAB_ADD_CHALLENGE_HINT = 'Aggiungi un '.$LNG->CHALLENGE_NAME;
$LNG->TAB_ADD_ISSUE_HINT = 'Aggiungi una '.$LNG->ISSUE_NAME;
$LNG->TAB_ADD_SOLUTION_HINT = 'Aggiungi una '.$LNG->SOLUTION_NAME;
$LNG->TAB_ADD_CLAIM_HINT = 'Aggiungi un\''.$LNG->CLAIM_NAME; //affermazione - masculine
$LNG->TAB_ADD_EVIDENCE_HINT = 'Aggiungi una '.$LNG->EVIDENCE_NAME;
$LNG->TAB_ADD_RESOURCE_HINT = 'Aggiungi una '.$LNG->RESOURCE_NAME;
$LNG->TAB_ADD_ORG_HINT = 'Aggiungi un '.$LNG->ORG_NAME;
$LNG->TAB_ADD_PROJECT_HINT = 'Aggiungi un '.$LNG->PROJECT_NAME;
$LNG->TAB_ADD_COMMENT_HINT = 'Aggiungi una '.$LNG->COMMENT_NAME;

$LNG->TAB_RSS_CHALLENGE_HINT = 'Ottieni un feed RSS per'.$LNG->CHALLENGES_NAME;
$LNG->TAB_RSS_ISSUE_HINT = 'Ottieni un feed RSS per'.$LNG->ISSUES_NAME;
$LNG->TAB_RSS_SOLUTION_HINT = 'Ottieni un feed RSS per'.$LNG->SOLUTIONS_NAME;
$LNG->TAB_RSS_CLAIM_HINT = 'Ottieni un feed RSS per'.$LNG->CLAIMS_NAME;
$LNG->TAB_RSS_EVIDENCE_HINT = 'Ottieni un feed RSS per'.$LNG->EVIDENCES_NAME;
$LNG->TAB_RSS_RESOURCE_HINT = 'Ottieni un feed RSS per'.$LNG->RESOURCES_NAME;
$LNG->TAB_RSS_ORG_HINT = 'Ottieni un feed RSS per'.$LNG->ORGS_NAME;
$LNG->TAB_RSS_PROJECT_HINT = 'Ottieni un feed RSS per'.$LNG->PROJECTS_NAME;
$LNG->TAB_RSS_COMMENT_HINT = 'Ottieni un feed RSS per'.$LNG->COMMENTS_NAME;

$LNG->TAB_RSS_ALT = 'RSS feed';
$LNG->TAB_PRINT_ALT = 'Stampa';
$LNG->TAB_PRINT_HINT_CHALLENGE = 'Stampa la lista di '.$LNG->CHALLENGES_NAME.'';
$LNG->TAB_PRINT_HINT_ISSUE = 'Stampa la lista di'.$LNG->ISSUES_NAME.'';
$LNG->TAB_PRINT_HINT_SOLUTION = 'Stampa la lista di'.$LNG->SOLUTIONS_NAME.'';
$LNG->TAB_PRINT_HINT_CLAIM = 'Stampa la lista di'.$LNG->CLAIMS_NAME.'';
$LNG->TAB_PRINT_HINT_EVIDENCE = 'Stampa la lista di'.$LNG->EVIDENCES_NAME.'';
$LNG->TAB_PRINT_HINT_RESOURCE = 'Stampa la lista di'.$LNG->RESOURCES_NAME.'';
$LNG->TAB_PRINT_HINT_ORG = 'Stampa la lista di'.$LNG->ORGS_NAME.' list';
$LNG->TAB_PRINT_HINT_PROJECT = 'Stampa la lista di'.$LNG->PROJECTS_NAME.'';
$LNG->TAB_PRINT_HINT_COMMENT = 'Stampa la lista di'.$LNG->COMMENTS_NAME.'';

$LNG->TAB_PRINT_TITLE_CHALLENGE = 'Evidence Hub: '.$LNG->CHALLENGES_NAME.' nelle liste';
$LNG->TAB_PRINT_TITLE_ISSUE = 'Evidence Hub: '.$LNG->ISSUES_NAME.' nelle liste';
$LNG->TAB_PRINT_TITLE_SOLUTION = 'Evidence Hub: '.$LNG->SOLUTIONS_NAME.' nelle liste';
$LNG->TAB_PRINT_TITLE_CLAIM = 'Evidence Hub: '.$LNG->CLAIMS_NAME.' nelle liste';
$LNG->TAB_PRINT_TITLE_EVIDENCE = 'Evidence Hub: '.$LNG->EVIDENCES_NAME.' nelle liste';
$LNG->TAB_PRINT_TITLE_RESOURCE = 'Evidence Hub: '.$LNG->RESOURCES_NAME.' nelle liste';
$LNG->TAB_PRINT_TITLE_ORG = 'Evidence Hub: '.$LNG->ORGS_NAME.' nelle liste';
$LNG->TAB_PRINT_TITLE_PROJECT = 'Evidence Hub: '.$LNG->PROJECTS_NAME.' nelle liste';
$LNG->TAB_PRINT_TITLE_COMMENT = 'Evidence Hub: '.$LNG->COMMENTS_NAME.' nelle liste';

/*
$LNG->TAB_SEARCH_ISSUE_LABEL = 'Cerca'.$LNG->ISSUES_NAME;
$LNG->TAB_SEARCH_SOLUTION_LABEL = 'Cerca''.$LNG->SOLUTIONS_NAME;
$LNG->TAB_SEARCH_CLAIM_LABEL = 'Cerca''.$LNG->CLAIMS_NAME;
$LNG->TAB_SEARCH_EVIDENCE_LABEL = 'Cerca''.$LNG->EVIDENCES_NAME;
$LNG->TAB_SEARCH_RESOURCE_LABEL = 'Cerca''.$LNG->RESOURCES_NAME;
$LNG->TAB_SEARCH_ORG_LABEL = 'Cerca''.$LNG->ORGS_NAME;
$LNG->TAB_SEARCH_PROJECT_LABEL = 'Cerca''.$LNG->PROJECTS_NAME;
$LNG->TAB_SEARCH_USER_LABEL = 'Cerca persone';
$LNG->TAB_SEARCH_COMMENT_LABEL = 'Cerca''.$LNG->COMMENTS_NAME;
$LNG->TAB_SEARCH_CHAT_LABEL = 'Cerca' '.$LNG->CHATS_NAME;
*/

$LNG->TAB_SEARCH_ISSUE_LABEL = 'Cerca';
$LNG->TAB_SEARCH_SOLUTION_LABEL = 'Cerca';
$LNG->TAB_SEARCH_CLAIM_LABEL = 'Cerca';
$LNG->TAB_SEARCH_EVIDENCE_LABEL = 'Cerca';
$LNG->TAB_SEARCH_RESOURCE_LABEL = 'Cerca';
$LNG->TAB_SEARCH_ORG_LABEL = 'Cerca';
$LNG->TAB_SEARCH_PROJECT_LABEL = 'Cerca';
$LNG->TAB_SEARCH_USER_LABEL = 'Cerca';
$LNG->TAB_SEARCH_COMMENT_LABEL = 'Cerca';
$LNG->TAB_SEARCH_CHAT_LABEL = 'Cerca';

$LNG->TAB_SEARCH_GO_BUTTON = 'Vai';
$LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON = 'Cancella ricerca corrente';

$LNG->TAB_CHALLENGE_MESSAGE = 'Esplora l\'insieme delle'.$LNG->CHALLENGES_NAME.' emerse. Queste forniscono punti di ancoraggio per aggiungere'.$LNG->ISSUES_NAME.', '.$LNG->SOLUTIONS_NAME.' e '.$LNG->EVIDENCES_NAME.'...';

$LNG->TAB_ISSUE_MESSAGE_LOGGEDIN = 'Esplora le domande chiave su cui gli utenti si stanno confrontando, e aggiungi le tue. Queste forniscono punti di ancoraggio per aggiungere '.$LNG->SOLUTIONS_NAME.' e '.$LNG->EVIDENCES_NAME.'...';
$LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_OPEN = "Esplora le domande chiave su cui gli utenti si stanno confrontando, e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere le tue. Queste forniscono punti di ancoraggio per aggiungere ".$LNG->SOLUTIONS_NAME." e ".$LNG->EVIDENCES_NAME."...";
$LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_REQUEST = "Esplora le domande chiave su cui gli utenti si stanno confrontando, e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere le tue. Queste forniscono punti di ancoraggio per aggiungere ".$LNG->SOLUTIONS_NAME." e ".$LNG->EVIDENCES_NAME."...";
$LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_CLOSED = 'Esplora le domande chiave su cui gli utenti si stanno confrontando, e <a title="Sign In" href="'.$CFG->homeAddress.'ui/pages/login.php">Sign In</a> per aggiungere le tue. Queste forniscono punti di ancoraggio per aggiungere '.$LNG->SOLUTIONS_NAME.' e '.$LNG->EVIDENCES_NAME.'...';

$LNG->TAB_SOLUTION_MESSAGE_LOGGEDIN = "Esplora le ".$LNG->SOLUTIONS_NAME." relative a  ".$LNG->ISSUES_NAME." - e aggiungi le tue, idealmente, con alcune affermazioni a sostegno/contro.";
$LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_OPEN = "Esplora le ".$LNG->SOLUTIONS_NAME." relative a  ".$LNG->ISSUES_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere le tue, idealmente, con alcune affermazioni a sostegno/contro.";
$LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_REQUEST = "Explore le ".$LNG->SOLUTIONS_NAME." relative a questa ".$LNG->ISSUES_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere le tue, idealmente, con alcune affermazioni a sostegno/contro.";
$LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_CLOSED = "Esplora le ".$LNG->SOLUTIONS_NAME." relative a ".$LNG->ISSUES_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> per aggiungere le tue, idealmente, con alcune affermazioni a sostegno/contro.";

$LNG->TAB_CLAIM_MESSAGE_LOGGEDIN = "Esplora le ".$LNG->CLAIMS_NAME." che gli utenti stanno formulando - e aggiungi le tue.";
$LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_OPEN = "Esplora le  ".$LNG->CLAIMS_NAME." che gli utenti stanno formulando - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere le tue.";
$LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_REQUEST = "Esplora le ".$LNG->CLAIMS_NAME." che gli utenti stanno formulando - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere le tue.";
$LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_CLOSED = "Esplora le  ".$LNG->CLAIMS_NAME." che gli utenti stanno formulando - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> per aggiungere le tue.";

/*
$temp = "";
if ($CFG->HAS_SOLUTION) {
	$temp .= $LNG->SOLUTIONS_NAME;
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$temp .= " e ";
}
if ($CFG->HAS_CLAIM) {
	$temp .= $LNG->CLAIMS_NAME;
}
*/
//$LNG->TAB_EVIDENCE_MESSAGE_LOGGEDIN = "Esplora le ".$LNG->EVIDENCES_NAME." a favore/contro per ".$temp." - e aggiungi le tue";
//$LNG->TAB_EVIDENCE_MESSAGE_LOGGEDOUT_OPEN = "Esplora le ".$LNG->EVIDENCES_NAME." a favore/contro per ".$temp." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere le tue.";
//$LNG->TAB_EVIDENCE_MESSAGE_LOGGEDOUT_REQUEST = "Esplora le ".$LNG->EVIDENCES_NAME." a favore/contro per ".$temp." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere le tue.";
//$LNG->TAB_EVIDENCE_MESSAG_LOGGEDOUT_CLOSED = "Esplora le ".$LNG->EVIDENCES_NAME." a favore/contro per ".$temp." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> per aggiungere le tue.";

$LNG->TAB_EVIDENCE_MESSAGE_LOGGEDIN = "Esplora le ".$LNG->EVIDENCES_NAME." inoltrate fino ad ora – a aggiungi le tue";
$LNG->TAB_EVIDENCE_MESSAGE_LOGGEDOUT_OPEN = "Esplora le ".$LNG->EVIDENCES_NAME." inoltrate fino ad ora - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere le tue.";
$LNG->TAB_EVIDENCE_MESSAGE_LOGGEDOUT_REQUEST = "Esplora le ".$LNG->EVIDENCES_NAME." inoltrate fino ad ora - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere le tue.";
$LNG->TAB_EVIDENCE_MESSAG_LOGGEDOUT_CLOSED = "Esplora le ".$LNG->EVIDENCES_NAME." inoltrate fino ad ora - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> per aggiungere le tue.";

$LNG->TAB_RESOURCE_MESSAGE_LOGGEDIN = "Esplora le ".$LNG->RESOURCES_NAME." - e aggiungi le tue.";
$LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_OPEN = "Esplora le ".$LNG->RESOURCES_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere le tue.";
$LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_REQUEST = "Esplora le ".$LNG->RESOURCES_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere le tue.";
$LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_CLOSED = "Esplora le ".$LNG->RESOURCES_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> per aggiungere le tue.";

$LNG->TAB_ORG_MESSAGE_LOGGEDIN = "Esplora i ".$LNG->ORGS_NAME." - e aggiungi il tuo.";
$LNG->TAB_ORG_MESSAGE_LOGGEDOUT_OPEN = "Esplora i ".$LNG->ORGS_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere il tuo.";
$LNG->TAB_ORG_MESSAGE_LOGGEDOUT_REQUEST = "Esplora i ".$LNG->ORGS_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere il tuo.";
$LNG->TAB_ORG_MESSAGE_LOGGEDOUT_CLOSED = "Esplora i ".$LNG->ORGS_NAME." - e<a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> per aggiungere il tuo.";

$LNG->TAB_PROJECT_MESSAGE_LOGGEDIN = "Esplora ".$LNG->PROJECTS_NAME." - e aggiungi i tuoi.";
$LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_OPEN = "Esplora ".$LNG->PROJECTS_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere i tuoi.";
$LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_REQUEST = "Esplora ".$LNG->PROJECTS_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere i tuoi.";
$LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_CLOSED = "Esplora ".$LNG->PROJECTS_NAME." - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> per aggiungere i tuoi.";

$LNG->TAB_USER_MESSAGE = "Clicca sul nome dell'utente per vedere il loro profilo e i loro contributi a Evidence Hub.";

/** HOMEPAGE **/
$LNG->HOMEPAGE_TITLE = 'Evidence Hub è una piattaforma pensata per condividere idee e proposte, e discuterne insieme.';
$LNG->HOMEPAGE_FIRST_PARA = 'Sei invitato a contribuire alla discussione e a presentare idee e proposte a supporto dello sviluppo dell\'Agenda Metropolitana Urbana per lo Sviluppo Sostenibile.';
$LNG->HOMEPAGE_KEEP_READING = 'continua a leggere';
$LNG->HOMEPAGE_READ_LESS = 'leggi meno';
$LNG->HOMEPAGE_SECOND_PARA_PART2 = 'Per contribuire puoi:';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<ul>';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<li>Mappare la tua organizzazione e i progetti/le iniziative e i servizi che ha attivato sui temi rilevanti per il progetto - Aggiungi un '.$LNG->PROJECTS_NAME.' and '.$LNG->ORGS_NAME.'</li>';
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= '<li>Mappare le tue sfide - Aggiungi un '.$LNG->ISSUES_NAME.', ';
if ($CFG->HAS_SOLUTION) {
	$LNG->HOMEPAGE_SECOND_PARA_PART2 .= $LNG->SOLUTIONS_NAME.', ';
}
if ($CFG->HAS_CLAIM) {
	$LNG->HOMEPAGE_SECOND_PARA_PART2 .= $LNG->CLAIMS_NAME.', ';
}
$LNG->HOMEPAGE_SECOND_PARA_PART2 .= $LNG->EVIDENCES_NAME.' e '.$LNG->RESOURCES_NAME.'</li></ul>';
$LNG->HOMEPAGE_CATEGORIES_CONNECT_TITLE = 'Come si connettono le categorie';
$LNG->HOMEPAGE_CATEGORIES_CONNECT_MESSAGE = 'L\'Evidence Hub unisce i pezzi del puzzle portati dagli individui in immagini più grandi che puoi esplorare e cercare in nuovi modi.';
$LNG->HOMEPAGE_CATEGORIES_CONNECT_HINT = '(icone rollover per visualizzare maggiori informazioni)';
$LNG->HOMEPAGE_QUICKGUIDE_LABEL = 'Visualizza';
$LNG->HOMEPAGE_QUICKGUIDE_HINT = 'Clicca per andare a una guida rapida all\'uso di Evidence Hub';
$LNG->HOMEPAGE_QUICKGUIDE_LINK = 'Guida Rapida';
$LNG->HOMEPAGE_THEME_TITLE = $LNG->THEMES_NAME;
$LNG->HOMEPAGE_GEOMAP_TITLE = 'Mappa delle organizzazioni e dei progetti';
$LNG->HOMEPAGE_GEOMAP_MESSAGE = '(Clicca immagine per vista attiva)';
$LNG->HOMEPAGE_TOOLS_TITLE = 'Strumenti:';
$LNG->HOMEPAGE_TOOLS_LINK = 'Ottieni la barra degli strumenti di Evidence Hub';
$LNG->HOMEPAGE_STORIES_TITLE = 'Storie:';
$LNG->HOMEPAGE_STORIES_OR = 'o';
$LNG->HOMEPAGE_STORIES_PRACTITIONER_LINK = 'Aggiungi la tua '.$LNG->PRACTITIONER_STORY_NAME;
$LNG->HOMEPAGE_STORIES_PRACTITIONER_HINT = 'Aggiungi la tua '.$LNG->PRACTITIONER_STORY_NAME;
$LNG->HOMEPAGE_STORIES_RESEARCHER_LINK = 'Aggiungi la tua '.$LNG->RESEARCHER_STORY_NAME;
$LNG->HOMEPAGE_STORIES_RESEARCHER_HINT = 'Aggiungi la run '.$LNG->RESEARCHER_STORY_NAME;
$LNG->HOMEPAGE_STORIES_LINK = 'Aggiungi la tua storia';
$LNG->HOMEPAGE_STORIES_HINT = 'Aggiungi la tua storia';
$LNG->HOMEPAGE_TAG_TITLE_PART1 = 'Top';
$LNG->HOMEPAGE_TAG_TITLE_PART2 = 'Tags:';

/** WIDGETS **/
$LNG->WIDGET_RESIZE_ITEM_ALT = 'Ridimensiona elemento';
$LNG->WIDGET_RESIZE_ITEM_HINT = 'Ridimensiona questa area';
$LNG->WIDGET_EXPAND_HINT = 'Espandi';
$LNG->WIDGET_ICON_ALT = 'Icona';
$LNG->WIDGET_OPEN_CLOSE_ALT = 'Apri/Chiudi elemento';
$LNG->WIDGET_OPEN_CLOSE_HINT = 'Apri/Chiudi questa area';
$LNG->WIDGET_CONTRACT_HINT = 'Contratto';
$LNG->WIDGET_LOADING = 'Caricamento in corso';
$LNG->WIDGET_LOAD = 'carica';
$LNG->WIDGET_LOADING_EVIDENCE = 'Sta caricando '.$LNG->EVIDENCES_NAME.'...';
$LNG->WIDGET_LOADING_RESOURCE = 'Sta caricando la relativa '.$LNG->RESOURCES_NAME.'...';
$LNG->WIDGET_LOADING_FOLLOWERS = 'Sta caricando '.$LNG->FOLLOWERS_NAME.'...';
$LNG->WIDGET_EVIDENCE_ADD_HINT = 'Seleziona/aggiungi un contributo da aggiungere come affermazione contro il seguente elemento';
$LNG->WIDGET_ADD_LINK = 'Aggiungi';
$LNG->WIDGET_SIGNIN_HINT = 'Accedi per contribuire all\'Evidence Hub';
$LNG->WIDGET_FOLLOW_SIGNIN_HINT = 'Accedi per seguire questo elemento';
$LNG->WIDGET_THEME_SELECT_OPTION = 'Seleziona '.$LNG->THEME_NAME.'...';
$LNG->WIDGET_ADD_BUTTON = 'Aggiungi';
$LNG->WIDGET_NO_RELATED_THEMES_FOUND = 'Nessun collegamento al '.$LNG->THEMES_NAME.'trovato';
$LNG->WIDGET_FOCUS_NODE_HINT = 'Clicca per visualizzare più informazioni';
$LNG->WIDGET_THEME_EXPLORE_HINT = 'Clicca per esplorare tutti i '.$LNG->THEMES_NAME.' per';
$LNG->WIDGET_CLICK_EXPLORE_HINT = 'Clicca per esplorare tutti i';
$LNG->WIDGET_CLICK_EXPLORE_HINT2 = 'Clicca per esplorare';
$LNG->WIDGET_THEME_EXPLORE_LINK = 'Esplora tutto';
$LNG->WIDGET_NO_RESULTS_FOUND = 'Nessun risultato trovato';
$LNG->WIDGET_NO_FOLLOWERS_FOUND = 'Nessum '.$LNG->FOLLOWERS_NAME.' trovato';
$LNG->WIDGET_HOW_EVIDENCE_RELATES_MESSAGE = 'Per favore indica come questa '.$LNG->EVIDENCE_NAME.' si relaziona?';
$LNG->WIDGET_ADD_COMMENT_HINT = 'Aggiungi un nuovo commento contro l\'attuale elemento focale';
$LNG->WIDGET_NONE_FOUND = 'Nessun elemento'; // for explore widget empty lists message
$LNG->WIDGET_NONE_FOUND2 = 'Nessun elemento'; // for chat lists and a couple of other places in debates

/** ADMIN AREA **/
$LNG->ADMIN_TITLE = "Area Amministrazione";
$LNG->ADMIN_BUTTON_HINT = "Questo viene lanciato in una nuova finestra";
$LNG->ADMIN_STATS_BUTTON_HINT = "Vai alle pagine di Analisi del sito";
$LNG->ADMIN_REGISTER_NEW_USER_LINK = 'Registra un nuovo '.$LNG->USER_NAME;
$LNG->ADMIN_MANAGE_THEMES_LINK = "Gestisci ".$LNG->THEMES_NAME;
$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE = 'Spiacenti, devi essere un amministratore per accedere a questa pagina';
$LNG->ADMIN_SQL_ERROR = 'SQL error:';
$LNG->ADMIN_MANAGE_USERS_DELETE_ERROR = 'Si è verificato un problema durante l\'eliminazione di '.$LNG->USER_NAME.' con ID:';
$LNG->ADMIN_MANAGE_THEMES_DELETE_ERROR = 'Si è verificato un problema durante l\'eliminazione di '.$LNG->THEME_NAME.' with con ID';

$LNG->ADMIN_THEME_MISSING_NAME_ERROR = 'Devi inserire un '.$LNG->THEME_NAME.'.';
$LNG->ADMIN_THEME_ID_ERROR  = 'Error passing '.$LNG->THEME_NAME.' id.';
$LNG->ADMIN_THEME_DELETE_QUESTION_PART1 = 'Sei sicuro di voler cancellare '.$LNG->THEME_NAME;
$LNG->ADMIN_THEME_DELETE_QUESTION_PART2 = '?\n\nNota:Eventuali associazioni fatte a questo '.$LNG->THEME_NAME.' saranno perse.\n\nQuesta azione non può essere annullata.';
$LNG->ADMIN_THEME_DELETE_SUCCESS_PART1 = $LNG->THEME_NAME;
$LNG->ADMIN_THEME_DELETE_SUCCESS_PART2 = 'è stata cancellata';
$LNG->ADMIN_THEME_TITLE = "Manage ".$LNG->THEMES_NAME;
$LNG->ADMIN_THEME_ADD_NEW_LINK = 'Aggiungi un nuovo '.$LNG->THEME_NAME;
$LNG->ADMIN_THEME_NAME_LABEL = 'Nome:';
$LNG->ADMIN_THEME_DESC_LABEL = 'Descrizione';
$LNG->ADMIN_THEME_THEME_HEADING = $LNG->THEME_NAME;
$LNG->ADMIN_THEME_ACTION_HEADING = 'Azione';
$LNG->ADMIN_THEME_EDIT_LINK = 'modifica';
$LNG->ADMIN_THEME_DELETE_LINK = 'cancella';
$LNG->ADMIN_THEME_IMAGE_LABEL = 'Immagine:';
$LNG->ADMIN_THEME_IMAGE_DELETE_LABEL = 'Cancella immagine';
$LNG->ADMIN_THEME_REPLACE_IMAGE_LABEL = 'Sostituisci immagine:';
$LNG->ADMIN_THEME_IMAGE_HELP = '(minimum size '.$CFG->THEME_IMAGE_WIDTH.'px w x '.$CFG->THEME_IMAGE_HEIGHT.'px h. Le immagini più grandi verranno ridimensionate/ritagliate a questa dimensione)';

$LNG->NODE_NEWS_POSTED_ON = 'Postato su';
$LNG->HOME_NEWS_TITLE = "Notizie Recenti";
$LNG->ADMIN_MANAGE_NEWS_LINK = "Gestisci ".$LNG->NEWSS_NAME;
$LNG->ADMIN_MANAGE_NEWS_DELETE_ERROR = 'Si è verificato un problema durante l\'eliminazione di '.$LNG->NEWS_NAME.' con questo ID:';
$LNG->ADMIN_NEWS_MISSING_NAME_ERROR = 'Devi inserire il titolo di una '.$LNG->NEWS_NAME.'.';
$LNG->ADMIN_NEWS_ID_ERROR  = 'Error passing '.$LNG->NEWS_NAME.' id.';
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART1 = 'Sei sicuro di voler cancellare  the '.$LNG->THEME_NAME;
$LNG->ADMIN_NEWS_DELETE_QUESTION_PART2 = '?';
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART1 = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_DELETE_SUCCESS_PART2 = 'è stata cancellata';
$LNG->ADMIN_NEWS_TITLE = "Manage ".$LNG->NEWSS_NAME;
$LNG->ADMIN_NEWS_ADD_NEW_LINK = 'Aggiungi un '.$LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_NAME_LABEL = 'Titolo:';
$LNG->ADMIN_NEWS_DESC_LABEL = 'Descrizione';
$LNG->ADMIN_NEWS_TITLE_HEADING = $LNG->NEWS_NAME;
$LNG->ADMIN_NEWS_ACTION_HEADING = 'Azione';
$LNG->ADMIN_NEWS_EDIT_LINK = 'modifica';
$LNG->ADMIN_NEWS_DELETE_LINK = 'cancella';

$LNG->ADMIN_USER_STATS_TITLE = 'Statistiche per';
$LNG->ADMIN_USER_STATS_NAME_HEADING = 'Nome';
$LNG->ADMIN_USER_STATS_ITEM_HEADING = 'Elemento';
$LNG->ADMIN_USER_STATS_COUNT_HEADING = 'Conto';
$LNG->ADMIN_USER_STATS_ACTION_HEADING = 'Azione';
$LNG->ADMIN_USER_STATS_POPULAR_LINK_HEADING = 'Tipo di collegamento più utilizzato';
$LNG->ADMIN_USER_STATS_VIEW_ALL = 'vedi tutto';
$LNG->ADMIN_USER_STATS_POPULAR_NODE_HEADING = 'Tipo di nodo più utilizzato';
$LNG->ADMIN_USER_STATS_POPULAR_TAG_HEADING = ' Tag';
$LNG->ADMIN_USER_STATS_TOP_TEN = 'top 10';
$LNG->ADMIN_USER_STATS_COMPARED_THINKING = 'Pensiero comparato';
$LNG->ADMIN_USER_STATS_INFO_BROKER = 'Broker di informazioni';
$LNG->ADMIN_USER_STATS_TOP_TEN_TAGS = 'Top 10 Tags';
$LNG->ADMIN_USER_STATS_TAG_HEADING = 'Tag';
$LNG->ADMIN_USER_STATS_COUNT_HEADING = 'Count';
$LNG->ADMIN_USER_STATS_LINK_TYPES_HEADING = 'Tipi di collegamento';
$LNG->ADMIN_USER_STATS_NODE_TYPES_HEADING = 'Tipi di nodo';
$LNG->ADMIN_USER_STATS_COMPARED_THINKING = 'Pensiero comparato';
$LNG->ADMIN_USER_STATS_INFORMATION_THINKING = 'Broker di informazioni';
$LNG->ADMIN_USER_STATS_SUMMARY_TITLE = 'Sintesi';
$LNG->ADMIN_USER_STATS_VOTE_TITLE = 'Voto dell\'elemento';

$LNG->ADMIN_CRON_FOLLOW_NEW_FOLLOWER_MESSAGE = 'Hai un nuovo follower chiamato';
$LNG->ADMIN_CRON_FOLLOW_USER_ACTIVITY_MESSAGE ="C'è stata attività per";
$LNG->ADMIN_CRON_FOLLOW_SEE_ACTIVITY_LINK = 'Vedi attività';
$LNG->ADMIN_CRON_FOLLOW_ACTIVITY_FOR = 'attività per';
$LNG->ADMIN_CRON_FOLLOW_EXPLORE_LINK = 'Esplora';
$LNG->ADMIN_CRON_FOLLOW_ON_THE = 'Sul';
$LNG->ADMIN_CRON_FOLLOW_THIS_ITEM = 'questo elemento';
$LNG->ADMIN_CRON_FOLLOW_STARTED = 'ha iniziato a seguire';
$LNG->ADMIN_CRON_FOLLOW_PROMOTED = 'promosso';
$LNG->ADMIN_CRON_FOLLOW_DEMOTED = 'osteggiato';
$LNG->ADMIN_CRON_FOLLOW_ADDED_THEME_TO = 'ha aggiunto questo tema '.$LNG->THEME_NAME.' a';
$LNG->ADMIN_CRON_FOLLOW_ADDED = 'ha aggiunto';
$LNG->ADMIN_CRON_FOLLOW_EDITED = 'ha modificato';
$LNG->ADMIN_CRON_FOLLOW_ADDED_RESOURCE = 'ha aggiunto una '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_ADDED_SUPPORTING_EVIDENCE = 'ha aggiunto una'.$LNG->EVIDENCE_NAME.' a favore';
$LNG->ADMIN_CRON_FOLLOW_ADDED_COUNTER_EVIDENCE = 'ha aggiunto una '.$LNG->EVIDENCE_NAME.'contraria';
$LNG->ADMIN_CRON_FOLLOW_LINKED_EVIDENCE = 'Connetti alla '.$LNG->EVIDENCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_LINKED_WITH = 'Connetti alla';
$LNG->ADMIN_CRON_FOLLOW_REMOVED_THEME_FROM  = 'rimuovi questo '.$LNG->THEME_NAME.' da';
$LNG->ADMIN_CRON_FOLLOW_REMOVED = 'rimosso';
$LNG->ADMIN_CRON_FOLLOW_REMOVED_RESOURCE = 'rimuovi la '.$LNG->RESOURCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_EVIDENCE = 'rimuovi la '.$LNG->EVIDENCE_NAME;
$LNG->ADMIN_CRON_FOLLOW_REMOVED_ASSOCIATION = 'ha rimosso la connessione';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART1 = 'Da';
$LNG->ADMIN_CRON_FOLLOW_DATE_FROM_TO_PART2 = 'a';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY = 'Settimanalmente';
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_TITLE = "Rapporto settimanale sull'attività dell'Evidence Hub";
$LNG->ADMIN_CRON_FOLLOW_WEEKLY_DIGEST_RUN = 'Riepilogo settimanale delle attività su '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_MONTHLY = 'Mensile';
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_TITLE = "Rapporto mensile sull'attività dell'Evidence Hub";
$LNG->ADMIN_CRON_FOLLOW_MONTHLY_DIGEST_RUN = 'Riepilogo mensile delle attività su '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_DAILY = 'Quotidiano';
$LNG->ADMIN_CRON_FOLLOW_DAILY_TITLE = "Rapporto quotidiano sull'attività dell'Evidence Hub";
$LNG->ADMIN_CRON_FOLLOW_DAILY_DIGEST_RUN = 'Riepilogo quotidiano delle attività su '.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_FOLLOW_NO_DIGEST = 'Nessun riepilogo per:';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART1 = 'Per non ricevere più questa e-mail di riepilogo, per favore accedi all\'hub e deseleziona\'Send email Alert of New Activity\' sul tuo';
$LNG->ADMIN_CRON_FOLLOW_UNSUBSCRIBE_PART2 = $LNG->HEADER_MY_HUB_LINK.' home page';
$LNG->ADMIN_REGISTER_WELCOME = 'Benvenuto su '.$CFG->SITE_TITLE;
$LNG->ADMIN_CREATE_USER_NODES_TITLE = 'Crea nodi utente';
$LNG->ADMIN_CREATE_LINK_TYPES_TITLE = 'Crea tipi di collegamento';
$LNG->ADMIN_CREATE_NODE_TYPES_TITLE = 'Crea tipi di nodi';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_DIGEST_RUN = 'Attività recenti condotte su'.$CFG->SITE_TITLE;
$LNG->ADMIN_CRON_RECENT_ACTIVITY_NO_DIGEST = 'Nessuna sintesi delle attività recenti per:';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_TITLE = 'Rapporto sulle attività recenti di Evidence Hub';
$LNG->ADMIN_CRON_RECENT_ACTIVITY_MESSAGE = 'Vedi sotto per i primi 5 elementi più recenti inseriti per ogni categoria Evidence Hub.';

/** HELP PAGES **/
$LNG->HELP_NETWORKMAP_TITLE = 'Mappa di rete';
$LNG->HELP_NETWORKMAP_BODY = '<b>Background:</b><br><br>&nbsp;&nbsp;&nbsp;';
$LNG->HELP_NETWORKMAP_BODY .= '<b>L-drag to pan</b><br>&nbsp;&nbsp;&nbsp;';
$LNG->HELP_NETWORKMAP_BODY .= '<b>R-Clicca</b> per adattare la rete allo schermo <br>&nbsp;&nbsp&nbsp;';
$LNG->HELP_NETWORKMAP_BODY .= '<b>R-trascina per ingrandire/rimpicciolire</b> <br><br>';
$LNG->HELP_NETWORKMAP_BODY .= '<b>Ideas:</b><br><br>&nbsp;&nbsp;&nbsp;';
$LNG->HELP_NETWORKMAP_BODY .= '<b>L-Clicca</b> per evidenziare cosa\'s connette<br>&nbsp;&nbsp;&nbsp;';
$LNG->HELP_NETWORKMAP_BODY .= '<b>L-Clicca</b> per visualizzare/modificare il suo profilo<br>&nbsp;&nbsp;&nbsp;';
$LNG->HELP_NETWORKMAP_BODY .= '<b>Duplica idea</b> (creato da >1 utente)ha un contorno<br>&nbsp;&nbsp;&nbsp;';
$LNG->HELP_NETWORKMAP_BODY .= '<b>L-Clicca duplicate Ideas</b> per visualizzare i profili nella lista delle idee<br><br>';
$LNG->HELP_NETWORKMAP_BODY .= '<b>Collegamenti:</b><br><br>&nbsp;&nbsp;&nbsp;';
$LNG->HELP_NETWORKMAP_BODY .= '<b>Mouse over blobs</b> per visualizzare una idea\'s<br>&nbsp;&nbsp;&nbsp;';

$LNG->HELP_BUILDER_TITLE = 'Barra degli strumenti di Evidence Hub';
$LNG->HELP_BUILDER_PARA1 = 'La barra degli strumenti di Evidence Hub consente di inserire dati in Evidence Hub durante la navigazione sul Web.';
$LNG->HELP_BUILDER_GET_TITLE = 'Come ottenere la barra degli strumenti';
$LNG->HELP_BUILDER_GET_LINK = 'Aggiungi questo link ai preferiti';
$LNG->HELP_BUILDER_USING_FIREFOX = 'Se usi <b>Firefox</b>, <b>Chrome</b> or <b>Safari</b> puoi trascinare il link sopra nella barra dei preferiti del tuo browser.';
$LNG->HELP_BUILDER_USING_OPERA = 'Se usi <b>Opera</b>, fai clic con il pulsante destro del mouse sul collegamento sopra, e seleziona\'Bookmark Link...\'. Poi puoi selezionare \'Show on bookmarks bar\'.';
$LNG->HELP_BUILDER_USING_IE = '<b>Only available for IE 9+</b>: trascina il link sopra nella barra dei preferiti del tuo browser ma riceverai un messaggio di avviso di sicurezza. Basta selezionare OK.';
$LNG->HELP_BUILDER_USING_IE_MORE_LINK = 'Più info su IE 9';
$LNG->HELP_BUILDER_USING_IE_HIDE_LINK = 'Nascondi';
$LNG->HELP_BUILDER_USING_IE_ERROR_TITLE = 'Noioso messaggio di sicurezza popup in IE 9';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART1 = 'Se vedi un avviso simile a quello sopra quando usi il nostro bookmarklet per favore segui queste istruzioni:';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 = '1. In Internet Explorer, select Tools &gt; Internet Options.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '2. Select the Security tab.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '3. Select "Trusted Sites" (the big green tick).<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '4. Clicca the "Custom level..." button.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '5. In the "Security Settings" dialog, scroll down to the "Miscellaneous" section.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '6. Find this setting: "Websites in less privileged content zone can navigate into this zone" and select "Enable."<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '7. Clicca OK to close the dialog, then OK to close Internet Options.<br>';
$LNG->HELP_BUILDER_USING_IE_ERROR_MESSAGE_PART2 .= '8. Restart Internet Explorer.';

$LNG->HELP_BUILDER_WARNING = "Nota: A causa dei cambiamenti nelle politiche di sicurezza sui browser, ora è possibile per i siti Web bloccare i bookmarklet come il nostro che caricano contenuti da un altro sito Web in modo che non funzionino sulle loro pagine Web.
Facebook e Twitter sono due esempi di siti che hanno implementato questa politica.
					Su questi siti, facendo clic sul nostro collegamento al bookmarklet al momento non viene eseguita alcuna operazione, quindi potrebbe sembrare non funzionante, ma è semplicemente bloccata.
					Il tuo browser potrebbe anche bloccare il bookmarklet, quindi potresti dover sovrascrivere le impostazioni di sicurezza del browser per farlo funzionare.
Stiamo studiando alternative per il futuro come plugin specifici per browser.
Per ora, questo bookmarklet funzionerà ancora sulla maggior parte dei siti Web che non hanno implementato questa politica.";

/** CORE **/
$LNG->CORE_UNKNOWN_USER_ERROR = 'Utente sconosciuto';
$LNG->CORE_NOT_IMAGE_ERROR = 'Spiacente, puoi caricare solo immagini.';
$LNG->CORE_NOT_IMAGE_TOO_LARGE_ERROR = 'Spiacenti, il file immagine è troppo grande.';
$LNG->CORE_NOT_IMAGE_UPLOAD_ERROR = 'Si è verificato un errore durante il caricamento dell\'immagine.';
$LNG->CORE_NOT_IMAGE_RESIZE_ERROR = 'Errore durante il ridimensionamento dell\'immagine.';
$LNG->CORE_NOT_IMAGE_SCALE_ERROR = 'Errore nel ridimensionamento dell\'immagine.';

$LNG->CORE_SESSION_OK = 'OK';
$LNG->CORE_SESSION_INVALID = 'Sessione non valida';

$LNG->CORE_AUDIT_NOT_XML_ERROR = 'Non è un file XML valido';
$LNG->CORE_AUDIT_CONNECTION_NOT_FOUND_ERROR = 'Connessione non trovata';
$LNG->CORE_AUDIT_NODE_NOT_FOUND_ERROR = 'Nodo non trovato';
$LNG->CORE_AUDIT_URL_NOT_FOUND_ERROR = 'URL non trovato';
$LNG->CORE_AUDIT_CONNECTION_ID_MISSING_ERROR = 'Dati ID connessione mancanti: impossibile caricare i dati';
$LNG->CORE_AUDIT_CONNECTION_DATA_MISSING_ERROR = 'Dati connessione mancanti';
$LNG->CORE_AUDIT_NODE_ID_MISSING_ERROR = 'Dati dell\'ID del nodo mancanti - il nodo non può essere caricato';
$LNG->CORE_AUDIT_NODE_DATA_MISSING_ERROR = 'Dati del nodo mancanti';
$LNG->CORE_AUDIT_URL_ID_MISSING_ERROR = 'Dati dell\'ID dell\'URL mancanti: impossibile caricare l\'URL';
$LNG->CORE_AUDIT_URL_DATA_MISSING_ERROR = 'Dati URL mancanti';
$LNG->CORE_AUDIT_TAG_ID_MISSING_ERROR = 'Dati ID tag mancanti - Il tag non può essere caricato';
$LNG->CORE_AUDIT_TAG_DATA_MISSING_ERROR = 'Dati tag mancanti';
$LNG->CORE_AUDIT_USER_ID_MISSING_ERROR = 'Dati ID utente mancanti: impossibile caricare l\'utente';
$LNG->CORE_AUDIT_USER_DATA_MISSING_ERROR = 'Dati iterate mancanti';
$LNG->CORE_AUDIT_GROUP_ID_MISSING_ERROR = 'Dati ID gruppo mancanti - Impossibile caricare il gruppo';
$LNG->CORE_AUDIT_GROUP_DATA_MISSING_ERROR = 'Dati gruppo mancanti';
$LNG->CORE_AUDIT_ROLE_ID_MISSING_ERROR = 'Dati identificativi del tipo di nodo mancanti - Impossibile caricare il tipo di nodo';
$LNG->CORE_AUDIT_ROLE_DATA_MISSING_ERROR = 'Dati del tipo di nodo mancanti';
$LNG->CORE_AUDIT_LINK_ID_MISSING_ERROR = 'Dati identificativi del tipo di collegamento mancanti - Impossibile caricare il tipo di collegamento';
$LNG->CORE_AUDIT_LINK_DATA_MISSING_ERROR = 'Dati del tipo di collegamento mancanti';

$LNG->CORE_FORMAT_NOT_IMPLEMENTED_MESSAGE = 'Non ancora implementato';
$LNG->CORE_FORMAT_INVALID_SELECTION_ERROR = 'Selezione formato non valida';

$LNG->CORE_HELP_ERRORCODES_TITLE = 'Aiuto - Codici di errore API';
$LNG->CORE_HELP_ERRORCODES_CODE_HEADING = 'Codice';
$LNG->CORE_HELP_ERRORCODES_MEANING_HEADING = 'Significato';

/**
 * THESE ARE ERROR MESSAGE SENT FROM THE API CODE
 * YOU MAY CHOOSE NOT TO TRANSLATE THESE
 */
$LNG->ERROR_REQUIRED_PARAMETER_MISSING_MESSAGE = "Required parameter missing";
$LNG->ERROR_INVALID_METHOD_SPECIFIED_MESSAGE = "Invalid or no method specified";
$LNG->ERROR_INVALID_ORDERBY_MESSAGE = "Invalid order by selection";
$LNG->ERROR_INVALID_SORT_MESSAGE = "Invalid sort selection";
$LNG->ERROR_BLANK_NODEID_MESSAGE = "The item id cannot be blank.";
$LNG->ERROR_ACCESS_DENIED_MESSAGE = "Access denied";
$LNG->ERROR_LOGIN_FAILED_MESSAGE = "Sign In failed: la tua mail or password are wrong. per favore  riprova.";
$LNG->ERROR_LOGIN_FAILED_UNAUTHORIZED_MESSAGE = "Sign In failed: This account has not yet been authorized";
$LNG->ERROR_LOGIN_FAILED_SUSPENDED_MESSAGE = "Sign In failed: This account has been suspended";
$LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE = "Sign In failed: This account has not completed the iscrizioneprocess by having its Email Address validated.";
$LNG->ERROR_LOGIN_FAILED_EXTERNAL_MESSAGE = "The account with the given email Address was created with an external service and does not have a local password.<br>Devi sign in to this account using:";

$LNG->ERROR_INVALID_METHOD_FOR_TYPE_MESSAGE = "Method not allowed for this format type";
$LNG->ERROR_DUPLICATION_MESSAGE = "Duplication Error";
$LNG->ERROR_INVALID_EMAIL_FORMAT_MESSAGE = "Invalid email format";
$LNG->ERROR_DATABASE_MESSAGE = "Database error";
$LNG->ERROR_USER_NOT_FOUND_MESSAGE = 'User not found in database';
$LNG->ERROR_URL_NOT_FOUND_MESSAGE = 'URL non trovato in database';
$LNG->ERROR_TAG_NOT_FOUND_MESSAGE = 'Tag not found in database';
$LNG->ERROR_ROLE_NOT_FOUND_MESSAGE = 'Node Type (Role) not found in database';
$LNG->ERROR_LINKTYPE_NOT_FOUND_MESSAGE = 'Link Type not found in database';
$LNG->ERROR_NODE_NOT_FOUND_MESSAGE = 'Nodo non trovato in database';
$LNG->ERROR_CONNECTION_NOT_FOUND_MESSAGE = 'Connessione non trovata in database';
$LNG->ERROR_INVALID_CONNECTION_MESSAGE = "Invalid connection combination. Does not match the datamodel.";
$LNG->ERROR_INVALID_PARAMETER_TYPE_MESSAGE = "Invalid parameter type";

$LNG->RECOMMENDATION_ORG_THEMES = $LNG->ORGS_NAME.'/'.$LNG->PROJECTS_NAME.' with shared '.$LNG->THEMES_NAME;
$LNG->RECOMMENDATION_ISSUE_THEMES = $LNG->ISSUES_NAME.' with shared '.$LNG->THEMES_NAME;
$LNG->RECOMMENDATION_SOLUTION_THEMES = $LNG->SOLUTIONS_NAME.' with shared '.$LNG->THEMES_NAME;
$LNG->RECOMMENDATION_CLAIM_THEMES = $LNG->CLAIMS_NAME.' with shared '.$LNG->THEMES_NAME;
$LNG->RECOMMENDATION_ISSUE_TAGS = $LNG->ISSUES_NAME.' with Shared Tags';


/****** NEW / CHANGESS FOR OPEN SOURCE RELEASE 2 ******/

/** REMOVED FROM VERSION 1
 *
 * EXPLORE PAGE STRAPLINES
 * $LNG->EXPLORE_CHALLENGE_STRAPLINE = 'Esplorando un '.$LNG->CHALLENGE_NAME.'....';
 * $LNG->EXPLORE_ISSUE_STRAPLINE = 'Esplorando un '.$LNG->ISSUE_NAME.'....';
 * $LNG->EXPLORE_CLAIM_STRAPLINE = 'Esplorando un '.$LNG->CLAIM_NAME.'....';
 * $LNG->EXPLORE_SOLUTION_STRAPLINE = 'Esplorando un '.$LNG->SOLUTION_NAME.'....';
 * $LNG->EXPLORE_ORG_STRAPLINE = 'Esplorando un '.$LNG->ORG_NAME.'....';
 * $LNG->EXPLORE_PROJECT_STRAPLINE = 'Esplorando un '.$LNG->PROJECT_NAME.'....';
 * $LNG->EXPLORE_EVIDENCE_STRAPLINE = 'Esplorando unn '.$LNG->EVIDENCE_NAME.'....';
 * $LNG->EXPLORE_RESOURCE_STRAPLINE = 'Esplorando un '.$LNG->RESOURCE_NAME.'....';
 * $LNG->EXPLORE_THEME_STRAPLINE = 'Esplorando un '.$LNG->THEME_NAME.'....';
 *
 * $LNG->FORM_LABEL_SELECT_EXISITING_RESOURCE = 'Select Existing '.$LNG->RESOURCE_NAME;
 */

/** NEWLY ADDED TO EXISTING SECTIONS ABOVE HERE FOR VERSION 2
 *
 * $LNG->FORM_SELECTOR_TITLE_DEFAULT
 * $LNG->FORM_BUTTON_CONTINUE
 * $LNG->NODE_RELEVANCE_ADD_MENU_TEXT
 * $LNG->NODE_RELEVANCE_EDIT_MENU_TEXT
 * $LNG->IMPORT_COMPENDIUM_FORM_MESSAGE
 * $LNG->IMPORT_COMPENDIUM_THEME_FORM_HINT
 * $LNG->IMPORT_COMPENDIUM_LOADING_DATA
 * $LNG->NODE_TOGGLE_HINT
 * $LNG->NODE_VOTE_MENU_TEXT
 * $LNG->USER_HOME_PROFILE_HEADING
 * $LNG->NETWORKMAPS_KEY_SOCIAL_MODERATELY
 * $LNG->NETWORKMAPS_KEY_SOCIAL_HIGHLY
 * $LNG->NETWORKMAPS_KEY_SOCIAL_SLIGHTLY
 * $LNG->NETWORKMAPS_KEY_SOCIAL_MOST
 * $LNG->FILTER_COUNTRY_DEFAULT
 * $LNG->IMPORT_COMPENDIUM_REQUIRED_FIELDS_MESSAGE_PART1
 * $LNG->IMPORT_COMPENDIUM_REQUIRED_FIELDS_MESSAGE_PART2
 * $LNG->NODE_VIEW_CONNECTOR_MENU_TEXT
 * $LNG->NODE_VIEW_CONNECTOR_MENU_HINT
 * $LNG->REGISTRATION_COMPLETE_TITLE
 * $LNG->REGISTRATION_FAILED
 * $LNG->REGISTRATION_FAILED_INVALID
 * $LNG->FORM_ERROR_MESSAGE_LOGIN
 * $LNG->PROFILE_EMAIL_VALIDATE_TEXT
 * $LNG->PROFILE_EMAIL_VALIDATE_HINT
 * $LNG->PROFILE_EMAIL_VALIDATE_MESSAGE
 * $LNG->PROFILE_EMAIL_VALIDATE_COMPLETE
 * $LNG->ERROR_LOGIN_FAILED_UNAUTHORIZED_MESSAGE
 * $LNG->ERROR_LOGIN_FAILED_SUSPENDED_MESSAGE
 * $LNG->ERROR_LOGIN_FAILED_UNVALIDATED_MESSAGE
 * $LNG->ERROR_LOGIN_FAILED_EXTERNAL_MESSAGE
 * $LNG->ADMIN_TITLE
 * $LNG->ADMIN_BUTTON_HINT
 * $LNG->ADMIN_STATS_BUTTON_HINT
 * $LNG->FORM_BUTTON_SKIP
 *
 * added when splitting Organization and Project to separate tabs etc.. in the interface.
 *
 * $LNG->TAB_PROJECT
 * $LNG->TAB_USER_PROJECT
 * $LNG->TAB_PROJECT_STRAPLINE
 * $LNG->TAB_PROJECT_INFO_HINT
 * $LNG->TAB_PROJECT_MESSAGE_LOGGEDIN
 * $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT
 * $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT
 * $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_CLOSED
 * $LNG->TAB_ADD_PROJECT_HINT
 * $LNG->TAB_ADD_PROJECT_LINK
 * $LNG->TAB_SEARCH_PROJECT_LABEL
 * $LNG->LOADING_PROJECTS
 * $LNG->TAB_PRINT_TITLE_PROJECT
 * $LNG->TAB_RSS_PROJECT_HINT
 * $LNG->TAB_PRINT_HINT_PROJECT
 * $LNG->LIST_NAV_USER_NO_PROJECT
 * $LNG->LIST_NAV_NO_PROJECTS
 * $LNG->GEO_PROJECT_LOADING
 * $LNG->TAB_PRINT_TITLE_COMMENT
 * $LNG->TAB_RSS_COMMENT_HINT
 * $LNG->TAB_PRINT_HINT_COMMENT
 * $LNG->DATAMODEL_challengeToProject
 * $LNG->DATAMODEL_issueToProject
 * $LNG->DATAMODEL_claimToProject
 * $LNG->DATAMODEL_solutionToProject
 * $LNG->DATAMODEL_evidenceToProject
 * $LNG->DATAMODEL_resourceToProject
 * $LNG->DATAMODEL_projectToIssue
 * $LNG->DATAMODEL_projectToClaim
 * $LNG->DATAMODEL_projectToSolution
 * $LNG->DATAMODEL_projectToChallenge
 * $LNG->DATAMODEL_projectToResource
 * $LNG->DATAMODEL_projectToEvidence
 * $LNG->EXPLORE_challengeToProject
 * $LNG->EXPLORE_issueToProject
 * $LNG->EXPLORE_claimToProject
 * $LNG->EXPLORE_solutionToProject
 * $LNG->EXPLORE_evidenceToProject
 * $LNG->EXPLORE_resourceToProject
 * $LNG->EXPLORE_themeToProject
 * $LNG->EXPLORE_PROJECTS_PROPOSING
 * $LNG->USER_HOME_IMPORT_BIBTEX_LINK
 * $LNG->COMMENT_TAG_FORM_HINT
 * $LNG->COMMENT_TAGha aggiunto_FORM_HINT
 * $LNG->COMMENT_DESC_FORM_HINT
 */

/** SEE ALSO RELATED ITEMS **/
$LNG->FORM_SELECT_EXISTING_ITEM = 'Seleziona documento esistente';
$LNG->FORM_LABEL_SEE_ALSO = 'Vedi anche';
$LNG->EXPLORE_SEE_ALSO = 'Vedi anche';
$LNG->CONNECT_SEE_ALSO = "Tutto come 'Vedi anche'";
$LNG->WIDGET_LOADING_SEE_ALSO = 'Caricamento elementi \'Vedi altro\'...';
$LNG->DELETE_CHECK_MESSAGE_SEE_ALSO = 'Sei sicuro di voler cancellare l\'elemento Vedi Altro ';

/** nuovo utente HOME PAGE ARRANGEMENT **/
$LNG->TAB_USER_DATA = 'I miei dati';
$LNG->TAB_USER_SOCIAL = 'La mia rete sociale';

$LNG->TAB_HOME_USER_STRAPLINE = "Benvenuto su home page per: ";

/** USER INNER TABS **/
$LNG->TAB_VIEW_GEOMAP_USER = 'Mappa - Utenti';
$LNG->TAB_VIEW_GEOMAP_USERNODE = 'Mappa - Voci Utente';

/** NEW GEOMAP FUNCTION */
$LNG->ZOOM_TO = 'Zoom su';

/** SEARCH HINT **/
$LNG->MAIN_SEARCH_INFO_HINT = "<div  style='padding:10px;'>La ricerca predefinita separerà le parole utilizzando gli spazi ed eseguirà una ricerca O, ad es. <b>'sistema scolastico'</b> cercherà le parole <b>'scuola' O 'sistema'</b> nel titolo dell'oggetto, nella descrizione dell'oggetto, nei tag dell'oggetto o in qualsiasi testo di clip web connesso.";
$LNG->MAIN_SEARCH_INFO_HINT .= "<br><br>Usa un '+' tra le parole si desideri eseguire una ricerca E, ad es.. <b>'scuola+sistema'</b> cercherà entrambe le parole nel titolo dell'oggetto, nella descrizione dell'oggetto, nei tag dell'oggetto o in qualsiasi testo di clip web connesso.";
$LNG->MAIN_SEARCH_INFO_HINT .= "<br><br>Utilizzare le virgolette attorno alla stringa di ricerca per eseguire una ricerca per frase, ad es.<b>\"sistema scolastico\"</b> will search for the <b>exact phrase 'school system'</b> nel titolo dell'oggetto, nella descrizione dell'oggetto, nei tag dell'oggetto o in qualsiasi testo di clip web connesso.</div>";

/** Mappa di rete **/
$LNG->TAB_VIEW_SOCIALMAP = 'Rete sociale';
$LNG->TAB_VIEW_USER_SOCIALMAP = 'La mia rete sociale';
$LNG->NETWORKMAPS_SOCIAL_ITEM_HINT = 'Apri la home page della persona attualmente selezionata';
$LNG->NETWORKMAPS_SOCIAL_ITEM_LINK = 'Esplora la persona selezionata';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT = 'Mostra tutti i collegamenti per il link selezionato';
$LNG->NETWORKMAPS_SOCIAL_CONNECTION_LINK = 'Esplora il collegamento selezionato';
$LNG->NETWORKMAPS_SOCIAL_LOADING_MESSAGE = '(Caricamento rete sociale Visualizza. Il calcolo potrebbe richiedere alcuni minuti a seconda delle dimensioni dell\'hub...)';
$LNG->NETWORKMAPS_SOCIAL_NO_RESULTS_MESSAGE = 'Nessun dato da cui calcolare la rete sociale.';

/** DEBATE/KNOWLEDGE TREE PAGE **/
$LNG->DEBATE_TREE_HEADING = 'Explore the Knowledge';
$LNG->DEBATE_ADD_HEADING = 'Aggiungi la tua conoscenza';

$LNG->DEBATE_SWITCH_WIDER_BUTTON = '(Visualizza alberi della conoscenza più ampi)';
$LNG->DEBATE_SWITCH_WIDER_HINT = 'Visualizza gli alberi della conoscenza completi e più ampi di cui l\'elemento corrente fa parte. Questo può richiedere un po\' di tempo per caricare.';
$LNG->DEBATE_SWITCH_NARROW_BUTTON = '(Visualizza alberi della conoscenza più ristretti)';
$LNG->DEBATE_SWITCH_NARROW_HINT = 'Visualizza solo gli alberi della conoscenza immediata di cui l\'elemento corrente fa parte';
$LNG->DEBATE_MISSING_SELECTED_ITEM_ERROR = 'L\'elemento attualmente selezionato non si trova in alcun albero della conoscenza più ristretto.';
$LNG->DEBATE_MISSING_ADDED_ITEM_QUESTION = 'Il nuovo elemento che hai appena aggiunto non apparirà nell\'albero delle conoscenze corrente.\n\nVuoi riorientare l\'albero delle conoscenze sul nuovo elemento?\n\n(Premi Annulla per rimanere su questa pagina)';
$LNG->DEBATE_HIGHLIGHT_ADDED_TEXT = '';
$LNG->DEBATE_LOADING = '(Caricamento del contenuto degli alberi della conoscenza...)';
$LNG->DEBATE_WIDER_LOADING = '(Caricamento di contenuti di alberi della conoscenza più ampi. Potrebbe volerci un po\' di tempo...)';

$LNG->DEBATE_NO_DEBATES_CHALLENGE = "Perché non avviare un albero aggiungendo la tua esperienza qui sotto?";
$LNG->DEBATE_NO_DEBATES_ISSUE = "Perché non avviare un albero aggiungendo la tua esperienza qui sotto?";
$LNG->DEBATE_NO_DEBATES_SOLUTION = "Perché non avviare un albero aggiungendo la tua esperienza qui sotto?";
$LNG->DEBATE_NO_DEBATES_CLAIM = "Perché non avviare un albero aggiungendo la tua esperienza qui sotto?";
$LNG->DEBATE_NO_DEBATES_EVIDENCE = "Perché non avviare un albero aggiungendo la tua esperienza qui sotto?";
$LNG->DEBATE_NO_DEBATES_RESOURCE = "";

$LNG->DEABTES_COUNT_MESSAGE_PART1 = 'questo elemento è contenuto in';
$LNG->DEABTES_COUNT_MESSAGE_PART2 = 'Albero/i della conoscenza';
$LNG->DEABTES_COUNT_THEME_MESSAGE_PART1 = 'Questo'.$LNG->THEME_NAME.' è in tutti gli elementi che formano'; // un numero sarà aggiunto a questo punto;
$LNG->DEABTES_COUNT_THEME_MESSAGE_PART2 = 'Albero/i della conoscenza.';
$LNG->DEABTES_COUNT_SEARCH_MESSAGE_PART1 = 'La ricerca produce';
$LNG->DEABTES_COUNT_SEARCH_MESSAGE_PART2 = 'Albero/i della conoscenza';
$LNG->DEABTES_HOME_BUTTON_HINT = 'Clicca per esplorare i dettagli completi su questo elemento';

//in debate tree menu - new hints
$LNG->NODE_RELEVANCE_ADD_MENU_HINT = 'Aggiungi il motivo per cui questa connessione è rilevante';
$LNG->NODE_RELEVANCE_EDIT_MENU_HINT = 'Modifica il motivo per cui questa connessione è rilevante';

$LNG->NODE_DEBATE_TOGGLE = 'Mostra/Nascondi l\'albero della conoscenza';
$LNG->NODE_DEBATE_ADD_HINT = '- Clicca per aggiungere conoscenza su questo elemento';
$LNG->NODE_DEBATE_BUTTON_TEXT = 'alberi della conoscenza';
$LNG->NODE_DEBATE_BUTTON_HINT = 'Vai ed esplora gli alberi della conoscenza su questo elemento';
$LNG->NODE_DEBATE_REFOCUS_MENU_TEXT = 'alberi della conoscenza';
$LNG->NODE_DEBATE_REFOCUS_MENU_HINT = 'Vai ed esplora gli alberi della conoscenza su questo elemento';
$LNG->NODE_DEBATE_ADD_TO_MENU_TEXT = 'Aggiungi';
$LNG->NODE_DEBATE_ADD_TO_PRO_MENU_TEXT = 'Aggiungi un '.$LNG->EVIDENCE_NAME.' a favore';
$LNG->NODE_DEBATE_ADD_TO_CON_MENU_TEXT = 'Aggiungi un '.$LNG->EVIDENCE_NAME.' contro';
$LNG->NODE_DEBATE_ADD_TO_SOLUTION_MENU_TEXT = 'Aggiungi un '.$LNG->SOLUTION_NAME;
$LNG->NODE_DEBATE_ADD_TO_RESOURCE_MENU_TEXT = 'Aggiungi un '.$LNG->RESOURCE_NAME;
$LNG->NODE_DEBATE_ADD_TO_CLAIM_MENU_TEXT = 'Aggiungi un '.$LNG->CLAIM_NAME;
$LNG->NODE_DEBATE_ADD_TO_ISSUE_MENU_TEXT = 'Aggiungi un '.$LNG->ISSUE_NAME;

$LNG->NODE_DEBATE_ADD_TO_MENU_HINT = 'Aggiungi la tua conoscenza su questo elemento';
$LNG->NODE_DEBATE_TREE_COUNT_HINT = 'Il numero di voci attualmente aggiunte a questo albero della conoscenza';

$LNG->NODE_GOTO_PARENT_HINT = '- Clicca per scorrere fino a questo';

/** NEW WIDGET PAGE SECTIONS **/
$LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING = 'Raccomandazioni';
$LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING = 'Ulteriori connessioni';
$LNG->EXPLORE_WIDGET_EXTRAS = 'Extra';

/** CHATS SYSTEM **/
$LNG->VIEWS_CHAT_TITLE = $LNG->CHATS_NAME;
$LNG->VIEWS_CHAT_HINT = 'Clicca per visualizzare  qualsiasi '.$LNG->CHATS_NAME.' su questo elemento';

$LNG->CHAT_USER_TITLE = 'Utenti attualmente su questa pagina';
$LNG->CHAT_USER_ENTRY_DATE = "Arrivato in questa chat:";

$LNG->CHAT_TREE_COUNT_HINT = 'Il numero di risposte attualmente aggiunte a questo argomento della '.$LNG->CHAT_NAME.'';
$LNG->CHAT_REPLY_TO_MENU_TEXT = 'Rispondi';
$LNG->CHAT_REPLY_TO_MENU_HINT = 'Post una risposta sulla '.$LNG->CHAT_NAME.' di questo elemento';
$LNG->CHAT_ADD_BUTTON_TEXT = 'Inizia una nuova'.$LNG->CHAT_NAME;
$LNG->CHAT_ADD_BUTTON_HINT = 'Inizia una nuova '.$LNG->CHAT_NAME.' sull\'elemento focale attuale';
$LNG->CHAT_LOADING = "Caricando ".$LNG->CHATS_NAME."...";
$LNG->NODE_CHAT_BUTTON_TEXT = $LNG->CHATS_NAME;
$LNG->NODE_CHAT_BUTTON_HINT = 'Vedi tutte le '.$LNG->CHATS_NAME.' su questo elemento';
$LNG->CHAT_TREE_TOGGLE = 'Mostra/Nascondi le risposte';
$LNG->NODE_REPLY_ON = 'aggiunte su';

$LNG->CHAT_CONVERT_TO_CHALLENGE_HINT = 'Converti questa '.$LNG->CHAT_NAME.' in una '.$LNG->CHALLENGE_NAME;
$LNG->CHAT_CONVERT_TO_ISSUE_HINT = 'Converti questa '.$LNG->CHAT_NAME.' in una '.$LNG->ISSUE_NAME;
$LNG->CHAT_CONVERT_TO_CLAIM_HINT = 'Converti questa '.$LNG->CHAT_NAME.' in una '.$LNG->CLAIM_NAME;
$LNG->CHAT_CONVERT_TO_SOLUTION_HINT = 'Converti questa '.$LNG->CHAT_NAME.' in una '.$LNG->SOLUTION_NAME;
$LNG->CHAT_CONVERT_TO_EVIDENCE_HINT = 'Converti questa '.$LNG->CHAT_NAME.' in una '.$LNG->EVIDENCE_NAME;
$LNG->CHAT_CONVERT_TO_RESOURCE_HINT = 'Converti questa '.$LNG->CHAT_NAME.' in una'.$LNG->RESOURCE_NAME;

$LNG->CHAT_CONVERT_TO_CHALLENGE_TEXT = 'Trasforma'.$LNG->CHALLENGE_NAME_SHORT;
$LNG->CHAT_CONVERT_TO_ISSUE_TEXT = 'Trasforma'.$LNG->ISSUE_NAME_SHORT;
$LNG->CHAT_CONVERT_TO_CLAIM_TEXT = 'Trasforma'.$LNG->CLAIM_NAME_SHORT;
$LNG->CHAT_CONVERT_TO_SOLUTION_TEXT = 'Trasforma'.$LNG->SOLUTION_NAME_SHORT;
$LNG->CHAT_CONVERT_TO_EVIDENCE_TEXT = 'Trasforma'.$LNG->EVIDENCE_NAME_SHORT;
$LNG->CHAT_CONVERT_TO_RESOURCE_TEXT = 'Trasforma'.$LNG->RESOURCE_NAME_SHORT;
$LNG->CHAT_COMMENT_PARENT_TREE = 'Quale'.$LNG->CHAT_NAME.' riguarda:';
$LNG->CHAT_COMMENT_PARENT_FOCUS = 'Questo elemento appare in una '.$LNG->CHAT_NAME.' su:';
$LNG->NODE_COMMENT_PARENT = 'Connesso a';

$LNG->CHAT_DELETE_CHECK_MESSAGE_PART1 = 'Sei sicuro di voler cancellare la'.$LNG->CHAT_NAME.': ';
$LNG->CHAT_DELETE_CHECK_MESSAGE_PART2 = '?';

$LNG->CHAT_HIGHLIGHT_NEWEST_TEXT = 'Risposta più recente';

$LNG->NODE_DISCONNECT_TREE_MENU_HINT = "Disconnetti da:";

/** GLOBAL STATS **/
$LNG->HOMEPAGE_STATS_LINK = "Evidence Hub Analytics";

$LNG->STATS_GLOBAL_TITLE = 'Evidence Hub Global Analytics';
$LNG->STATS_GLOBAL_TAB_OVERVIEW = 'Panoramica';
$LNG->STATS_GLOBAL_TAB_REGISTER = 'iscrizione utente';
$LNG->STATS_GLOBAL_TAB_IDEAS = 'Items Created';
$LNG->STATS_GLOBAL_TAB_CONNS = 'Connessione creata';
$LNG->STATS_GLOBAL_TAB_TAGS = 'Tutti i tag';
$LNG->STATS_GLOBAL_TAB_VOTES = 'Votando';

$LNG->STATS_GLOBAL_VOTES_TOP_NODES = 'Top 10 Voti SULL\'elemento';
$LNG->STATS_GLOBAL_VOTES_TOP_FOR_NODES = "Top 10 Voti A FAVORE dell\'elemento";
$LNG->STATS_GLOBAL_VOTES_TOP_AGAINST_NODES = "Top 10 Votu CONTRO l\'elemento";
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING = 'Nome';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING = 'Totale';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING = 'Per';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING = 'Contro';
$LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING = "Categoria";
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS = 'Top 10 Votanti';
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_FOR = 'Top 10 Votanti A FAVORE';
$LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_AGAINST = 'Top 10 Votanti CONTRO';
$LNG->STATS_GLOBAL_VOTES_VOTING_MENU_TITLE = 'Visualizza gli elementi più votati';
$LNG->STATS_GLOBAL_VOTES_VOTERS_MENU_TITLE = 'Visualizza i TOP Votanti';
$LNG->STATS_GLOBAL_VOTES_ALL_VOTES_MENU_TITLE = 'Visualizza tutti gli elementi votati';
$LNG->STATS_GLOBAL_VOTES_BACK_UP = 'Torna al menu opzioni';
$LNG->STATS_GLOBAL_VOTES_MENU_TITLE = 'Statistiche di Voto';
$LNG->STATS_GLOBAL_ITEM_VOTES_MENU_TITLE = 'Statistiche di Voto degli elementi';
$LNG->STATS_GLOBAL_CONNECTION_VOTES_MENU_TITLE = 'Statistiche di Voto delle connessioni';
$LNG->STATS_GLOBAL_ALL_VOTES_MENU_TITLE = 'Tutte le statistiche di voto';
$LNG->STATS_GLOBAL_VOTES_ALL_VOTING_TITLE = 'Tutti gli elementi per il voto';
$LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING = 'Elemento a favore';
$LNG->STATS_GLOBAL_VOTES_ITEM_AGAINST_HEADING = 'Elemento contrario';
$LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING = 'Connessione a favore';
$LNG->STATS_GLOBAL_VOTES_CONN_AGAINST_HEADING = 'Connessione contro';

$LNG->STATS_GLOBAL_OVERVIEW_HEADER_TYPE = 'Tipo';
$LNG->STATS_GLOBAL_OVERVIEW_HEADER_NAME = 'Nome';
$LNG->STATS_GLOBAL_OVERVIEW_HEADER_COUNT = 'Conto';
$LNG->STATS_GLOBAL_OVERVIEW_USED_LINKS_LABEL = 'Tipo di connessione più utilizzato';
$LNG->STATS_GLOBAL_OVERVIEW_USED_IDEAS_LABEL = 'Tipo di elemento più utilizzato';
$LNG->STATS_GLOBAL_OVERVIEW_CONNECTED_IDEA_LABEL = 'Elemento più connesso';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS = 'I migliori costruttori di connessioni';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_IDEA_CREATORS = 'I migliori creatori di elementi';
$LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS_LINKS = 'I migliori costruttori di connessioni - Il loro uso di LinkType';
$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART1 = 'Per visualizzare le tue analytics personali vai al tuo';
$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART2 = 'Pagina iniziale';
$LNG->STATS_GLOBAL_OVERVIEW_USED_TAG_LABEL = 'Tag più utilizzato';
$LNG->STATS_GLOBAL_OVERVIEW_USED_THEME_LABEL = $LNG->THEME_NAME.' più utilizzato';

$LNG->STATS_GLOBAL_REGISTER_TOTAL_LABEL = 'Conto totale utenti';
$LNG->STATS_GLOBAL_REGISTER_HEADER_NAME = 'Nome';
$LNG->STATS_GLOBAL_REGISTER_HEADER_DATE = 'Data';
$LNG->STATS_GLOBAL_REGISTER_HEADER_DESC = 'Descrizione';
$LNG->STATS_GLOBAL_REGISTER_HEADER_WEBSITE = 'Sito';
$LNG->STATS_GLOBAL_REGISTER_HEADER_LOCATION = 'Luogo';
$LNG->STATS_GLOBAL_REGISTER_HEADER_INTEREST = 'Interesse';
$LNG->STATS_GLOBAL_REGISTER_HEADER_LAST_LOGIN = 'Ultimo accesso';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_MONTH_TITLE = 'iscrizione utente per mese';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_WEEK_TITLE = 'iscrizione utente per settimana';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_X_LABEL = 'Numero di registrazioni';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_MONTH_Y_LABEL = 'Mesi (da';
$LNG->STATS_GLOBAL_REGISTER_GRAPH_WEEK_Y_LABEL = 'Settimane (da';

$LNG->STATS_GLOBAL_IDEAS_TOTAL_LABEL = 'Conto totale';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_WEEK_TITLE  ='Creazione settimanale di elementi nell\'ultimo anno';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_MONTH_TITLE  ='Creazione mensile di elementi nell\'ultimo anno';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_MONTH_Y_LABEL = 'Mesi (da';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_WEEK_Y_LABEL = 'Settimane (da';
$LNG->STATS_GLOBAL_IDEAS_GRAPH_X_LABEL = 'Numero di idee';

$LNG->STATS_GLOBAL_CONNS_TOTAL_LABEL = 'Calcolo totale dei collegamenti';
$LNG->STATS_GLOBAL_IDEAS_MONTHLY_TOTAL_LABEL = 'Totale mensile';
$LNG->STATS_GLOBAL_CONNS_GRAPH_WEEK_TITLE  ='Creazione settimanale di elementi nell\'ultimo anno';
$LNG->STATS_GLOBAL_CONNS_GRAPH_MONTH_TITLE  ='Creazione mensile di elementi nell\'ultimo anno';
$LNG->STATS_GLOBAL_CONNS_GRAPH_MONTH_Y_LABEL = 'Mesi (da';
$LNG->STATS_GLOBAL_CONNS_GRAPH_WEEK_Y_LABEL = 'Settimane (da';
$LNG->STATS_GLOBAL_CONNS_GRAPH_X_LABEL = 'Numero di connessioni';

/** BIBTEX IMPORT **/
$LNG->IMPORT_BIBTEX_TITLE = 'Importa da Bib TeX';
$LNG->IMPORT_BIBTEX_HELP_LINK = 'Aiuto';
$LNG->IMPORT_BIBTEX_FILE_UPLOAD_ERROR = 'Si è verificato un errore durante il caricamento del file';
$LNG->IMPORT_BIBTEX_NO_FILE = 'Devi prima selezionare un file.';
$LNG->IMPORT_BIBTEX_FORM_MESSAGE = 'Per favore seleziona il file Bib TeX da importare.';
$LNG->IMPORT_BIBTEX_IMPORT_BUTTON = 'Importa';
$LNG->IMPORT_BIBTEX_PROBLEMS_ERROR = 'Sono stati riscontrati i seguenti problemi durante il caricamento, per favore  riprova:';
$LNG->IMPORT_BIBTEX_SUCCESS_MESSAGE = 'Il file è stato caricato e importato con successo:';
$LNG->IMPORT_BIBTEX_FILE_LABEL = 'File Bib TeX:';
$LNG->IMPORT_BIBTEX_TYPE_ERROR = 'Il file da importare deve essere un file bibtex che termina con .bib';
$LNG->IMPORT_BIBTEX_LOADING_DATA = '(Importazione dei dati Bib TeX in corso... Nota: il tempo impiegato varia in base alla dimensione del file di importazione )';
$LNG->IMPORT_BIBTEX_THEME_FORM_HINT = '(obbligatorio)- Seleziona almeno un'.$LNG->THEME_NAME.' da connettere a tutte le pubblicazioni che vengono importate. Puoi inserirne più di uno.';
$LNG->IMPORT_BIBTEX_ITEM_ADDED_MESSAGE = 'Elemento aggiunto:';
$LNG->IMPORT_BIBTEX_REQUIRED_FIELDS_MESSAGE_PART1 = '(I campi con un';
$LNG->IMPORT_BIBTEX_REQUIRED_FIELDS_MESSAGE_PART2 = 'sono obbligatori)';
$LNG->IMPORT_BIBTEX_GOTO_RESOURCES = 'Visualizza le mie risorse';

/** SPAM REPORTING **/
$LNG->SPAM_CONFIRM_MESSAGE_PART1= 'Sei sicuro di voler segnalare';
$LNG->SPAM_CONFIRM_MESSAGE_PART2= 'come Spam / Inappropriato?';
$LNG->SPAM_SUCCESS_MESSAGE = 'è stato segnalato come spam';
$LNG->SPAM_REPORTED_TEXT = 'segnalato come spam';
$LNG->SPAM_REPORTED_HINT = 'Questo è stato segnalato come spam / contenuto non appropriato';
$LNG->SPAM_REPORT_TEXT = 'Segnala come Spam';
$LNG->SPAM_REPORT_HINT = 'Segnala come Spam / contenuto non appropriato';
$LNG->SPAM_LOGIN_REPORT_TEXT = 'Accedi per segnalare come spam';
$LNG->SPAM_LOGIN_REPORT_HINT = 'Accedi per segnalare questo come spam / contenuto non appropriato';
$LNG->SPAM_ADMIN_MANAGER_SPAM_LINK = "Contenuto segnalato";
$LNG->SPAM_ADMIN_TITLE = "Item Report Manager";
$LNG->SPAM_ADMIN_ID_ERROR = "Impossibile elaborare la richiesta perché manca l\'ID del nodo";
$LNG->SPAM_ADMIN_TABLE_HEADING0 = "Segnalato da";
$LNG->SPAM_ADMIN_TABLE_HEADING1 = "Titolo";
$LNG->SPAM_ADMIN_TABLE_HEADING2 = "Azione";
$LNG->SPAM_ADMIN_DELETE_CHECK_MESSAGE = "Sei sicuro di voler cancellare l\'elemento?: ";
$LNG->SPAM_ADMIN_RESTORE_CHECK_MESSAGE = "Sei sicuro di volerlo segnalare come NON SPAM?: ";
$LNG->SPAM_ADMIN_RESTORE_BUTTON = "Non Spam";
$LNG->SPAM_ADMIN_DELETE_BUTTON = "Cancella";
$LNG->SPAM_ADMIN_VIEW_BUTTON = "Visualizza dettagli";
$LNG->SPAM_ADMIN_NONE_MESSAGE = 'Al momento non ci sono articoli segnalati come spam/inappropriati';

$LNG->SPAM_USER_REPORTED = 'L\'utente è stato segnalato come Spammer / Inappropriato';
$LNG->SPAM_USER_REPORT = 'Segnala questo '.$LNG->USER_NAME.' come Spammer / Inappropriato';
$LNG->SPAM_USER_LOGIN_REPORT = 'Accedi per segnalare questo utente o gruppo come spam/inappropriato';
$LNG->SPAM_USER_REPORTED_ALT = 'Segnalato';
$LNG->SPAM_USER_REPORT_ALT = 'Report';
$LNG->SPAM_USER_LOGIN_REPORT_ALT = 'Accedi per segnalare';
$LNG->SPAM_USER_ADMIN_TABLE_HEADING0 = "Segnalato da";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING1 = $LNG->USER_NAME." Nome";
$LNG->SPAM_USER_ADMIN_TABLE_HEADING2 = "Azione";
$LNG->SPAM_USER_ADMIN_VIEW_BUTTON = "Visualizza la home nell'".$LNG->USER_NAME;
$LNG->SPAM_USER_ADMIN_VIEW_HINT = "Apri una nuova finestra che mostri la homepage di questo ".$LNG->USER_NAME;
$LNG->SPAM_USER_ADMIN_RESTORE_BUTTON = "Ripristina account";
$LNG->SPAM_USER_ADMIN_RESTORE_HINT = "Ripristina l'account di questo ".$LNG->USER_NAME." come attivo";
$LNG->SPAM_USER_ADMIN_DELETE_BUTTON = "Cancella account";
$LNG->SPAM_USER_ADMIN_DELETE_HINT = "Cancella l'account di questo ".$LNG->USER_NAME." e tutti i suoi dati";
$LNG->SPAM_USER_ADMIN_SUSPEND_BUTTON = "Sospendi account";
$LNG->SPAM_USER_ADMIN_SUSPEND_HINT = "Sospendi questo account e impediscigli di accedere ".$LNG->USER_NAME."";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART1 = "Sei sicuro di voler cancellare l' ".$LNG->USER_NAME.": ";
$LNG->SPAM_USER_ADMIN_DELETE_CHECK_MESSAGE_PART2 = "Attenzione: tutti i loro dati verranno eliminati definitivamente. Se non l'hai fatto, dovresti prima controllare i loro contributi cliccando'".$LNG->SPAM_USER_ADMIN_VIEW_BUTTON."'";
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART1 = "Sei sicuro di voler ripristinare l'account di: ";
$LNG->SPAM_USER_ADMIN_RESTORE_CHECK_MESSAGE_PART2 = "Questo rimuoverà questo".$LNG->USER_NAME." dalla lista";
$LNG->SPAM_USER_ADMIN_SUSPEND_CHECK_MESSAGE = "Sei sicuro di voler sospendere l'account: ";
$LNG->SPAM_USER_ADMIN_NONE_MESSAGE = "Al momento non ci sono ".$LNG->USERS_NAME." segnalati come spammer / Inappropriati";
$LNG->SPAM_USER_ADMIN_TITLE = "Gestione rapporti utente";
$LNG->SPAM_USER_ADMIN_MANAGER_SPAM_LINK = "Segnalato ".$LNG->USERS_NAME;
$LNG->SPAM_USER_ADMIN_ID_ERROR = "Impossibile elaborare la richiesta perché manca l'ID";
$LNG->SPAM_USER_ADMIN_NONE_SUSPENDED_MESSAGE = 'Al momento non ci sono '.$LNG->USERS_NAME.' suspesi';
$LNG->SPAM_USER_ADMIN_SPAM_TITLE = $LNG->USER_NAME.' Segnalato';
$LNG->SPAM_USER_ADMIN_SUSPENDED_TITLE = $LNG->USER_NAME.' Sospeso';

/** HISTORY BAR **/
$LNG->HISTORY_ITEM_HINT = 'Clicca per esplorare';

/** EXTERNAL LOGIN **/
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_0 = 'Errore non specificato.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_1 = 'Errore di configurazione dell\'ibridazione.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_2 = 'Provider non configurato correttamente.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_3 = 'Provider sconosciuto o disabilitato.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_4 = 'Credenziali dell\'applicazione provider mancanti.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_5 = 'Autenticazione fallita. L\'utente ha annullato l\'autenticazione o il provider ha rifiutato la connessione.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_6 = 'Richiesta del profilo utente non riuscita. Molto probabilmente l\'utente non è connesso al provider e dovrebbe riprovare ad autenticarsi.';
$LNG->LOGIN_EXTERNAL_ERROR_HYBRIDAUTH_7 = 'Utente non connesso al provider.';

$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED = 'Un account Evidence Hub '.$LNG->USER_NAME.'  esiste già su questo sito utilizzando l\'indirizzo email del tuo profilo esterno, ma quell\'account utente non ha completato il processo di iscrizione.<br>Se possiedi quell\'account utente, devi rispondere all\'e-mail che ti è stata inviata per completare la iscrizione, prima di poter accedere.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNVALIDATED_EXISTING = 'Un account Evidence Hub'.$LNG->USER_NAME.' esiste già su questo sito utilizzando l\'indirizzo e-mail dal tuo profilo esterno, ma quell\'account utente Evidence Hub non ha ancora verificato l\'indirizzo e-mail.<br><br>Se possiedi quell\'account utente Evidence Hub devi prima <a href="'.$CFG->homeAddress.'ui/pages/login.php">Accedi</a> usando quell\'account e verificare il tuo indirizzo mail dalla pagina del tuo profilo, prima di poter utilizzare servizi esterni per accedere a questo Hub in futuro.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_UNAUTHORIZED = 'Un account Evidence Hub '.$LNG->USER_NAME.' esiste già utilizzando l\'indirizzo email dal tuo profilo esterno, tuttavia quell\'account è in attesa di autorizzazione, quindi non possiamo farti accedere in questo momento.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_SUSPENDED = 'Un account Evidence Hub'.$LNG->USER_NAME.' esiste già su questo sito utilizzando l\'indirizzo email sul tuo profilo esterno, tuttavia l\'account è stato attualmente sospeso, quindi non possiamo farti accedere in questo momento.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED = 'Sembra che tu abbia provato ad accedere con'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 = 'prima ma non ha completato la convalida dell\'e-mail richiesta.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 .= '<br><br>per favore rispondi all\'e-mail che ti è stata inviata, prima di provare ad accedere nuovamente con questo servizio.';
$LNG->LOGIN_EXTERNAL_ERROR_ACCOUNT_PROVIDER_UNVALIDATED_PART2 .= '<br><br>In alternativa, richiedi un\'altra email di convalida cliccando il pulsante qui sotto.';
$LNG->LOGIN_EXTERNAL_ERROR_USER_LOAD_FAILED = 'Impossibile caricare l\'account utente: ';
$LNG->LOGIN_EXTERNAL_ERROR_REGISTRATION_CLOSED = "In base all\'indirizzo e-mail fornito, possiamo vedere che non hai ancora un account con noi.<br><br>Purtroppo la iscrizione su questo sito è attualmente solo su invito.";
$LNG->LOGIN_EXTERNAL_ERROR_REQUIRES_AUTHORISATION = 'In base all\'indirizzo e-mail fornito, possiamo vedere che non hai ancora un account con noi.<br><br>Questo Evidence Hub attualmente richiede la Richiesta di iscrizione per essere autorizzato<br>Quindi per favore vai alla pagine <a href="'.$CFG->homeAddress.'ui/pages/Registrarequest.php">Iscriviti</a>  e compila il modulo di Richiesta di iscrizione.';

$LNG->LOGIN_EXTERNAL_FIRST_TIME = 'Possiamo vedere che questa è la prima volta che provi ad accedere a questo sito utilizzando'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_EMAIL_UNVALIDATED_PART1 = '<br><br>Purtroppo l\'indirizzo email sulle informazioni del profilo in loro possesso non è stato verificato da loro. Quindi, prima di poter connettere questo profilo esterno a un account nel nostro Hub, dobbiamo convalidare l\'indirizzo e-mail.<br><br>Pertanto ti è stata inviata una mail. per favore Clicca sul link nell\'email per completare la iscrizione del tuo'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_EMAIL_UNVALIDATED_PART2 = 'profilo.';

$LNG->LOGIN_EXTERNAL_ERROR_NO_EMAIL_PART1 = '<br><br>Purtroppo'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_ERROR_NO_EMAIL_PART2 = 'non ci ha fornito il tuo indirizzo mail, quindi non possiamo verificare se hai già un account con noi o crearne uno nuovo se richiesto.<br><br>Pertanto, per favore inserisci l\'indirizzo email che desideri utilizzare su questo Evidence Hub in basso e premi Accedi.';

$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE = 'Riceverai a breve un\'email.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE .= '<br>Devi Clicca sul link per completare la iscrizione.';

$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 = 'There was no existing Hub user account for the email Address on your external profile, so we have now created one and Associad it to that external profile.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 .= '<br>Tuttavia, l\'indirizzo e-mail non è stato convalidato dal fornitore di servizi esterno, quindi prima di poter completare la iscrizione dobbiamo prima convalidare che l\'indirizzo e-mail ti appartenga.';
$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE2 .= '<br><br>'.$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE;

$LNG->LOGIN_EXTERNAL_TITLE = 'Social Sign On';
$LNG->LOGIN_EXTERNAL_MESSAGE = 'Ti è stata inviata Una mail per verificare il tuo indirizzo mail. per favore clicca sul link nell\'email per completare questo processo';

$LNG->LOGIN_EXTERNAL_COMPLETE_TITLE = 'SOCIAL SIGN ON - Completamento della convalida dell\'e-mail';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED = 'Il record di accesso social connesso con l\'id specificato non è più disponibile. per favore prova a registrarti/accedere di nuovo.';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED = 'la convalida della tua mail non può essere completata poiché l\'ID record fornito non è valido. per favore prova a registrarti/accedere di nuovo';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_USER = 'L\'account utente esistente associato all\'indirizzo e-mail fornito non è più disponibile';
$LNG->LOGIN_EXTERNAL_COMPLETE_FAILED_INVALID = 'Non è stato possibile completare la convalida della tua posta poiché la chiave di convalida fornita non era valida per l\'ID record del provider esterno specificato. <br><br>per favore riprova utilizzando un provider diverso, oppure crea un account Evidence Hub locale';
$LNG->LOGIN_EXTERNAL_REGISTER_COMPLETE_FAILED = 'Non è stato possibile completare la iscrizione in quanto l\'ID utente fornito non apparteneva al record del provider esterno fornito.<br><br>per favore riprova utilizzando un provider diverso, oppure crea un account Evidence Hub locale';

// Messages used when the provider didn\'t supply the email Address so the user was asked to
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS = 'Un account utente Evidence Hub esiste già su questo sito utilizzando l\'indirizzo e-mail che ci hai fornito';

$LNG->LOGIN_EXTERNAL_UNVALIDATED_TITLE = 'convalida il tuo indirizzo e-mail Evidence Hub';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.',ma quell\'account utente non ha completato il processo di iscrizione.<br><br>Se possiedi quell\'account utente Evidence Hub devi rispondere all\'e-mail che ti è stata inviata per completare la iscrizione, prima di poter utilizzare qualsiasi servizio esterno per accedere a questo Hub.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNVALIDATED_EXISTING = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', ma l\'indirizzo e-mail dell\'account utente di Evidence Hub non è ancora stato convalidato.<br><br>Se possiedi quell\'account utente di Evidence Hub devi prima <a href="'.$CFG->homeAddress.'ui/pages /login.php">Accedi</a> utilizzando quell\'account e convalida il tuo indirizzo mail dalla pagina del tuo profilo, prima di poter utilizzare qualsiasi servizio esterno per accedere a questo Hub in futuro.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_UNAUTHORIZED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', tuttavia quell\'account è in attesa di autorizzazione, quindi non possiamo farti accedere in questo momento.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_ERROR_ACCOUNT_SUSPENDED = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.', htuttavia quell\'account è stato sospeso, quindi non possiamo farti accedere in questo momento.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART1 = 'convalida il tuo';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_TITLE_PART2 = 'indirizzo mail';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART1 = $LNG->LOGIN_EXTERNAL_NO_EMAIL_ACCOUNT_EXISTS.'. Per permetterci di connettere il tuo'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_EXISTING_VALIDATE_MESSAGE_PART2 = 'account con questo account utente Evidence Hub, dobbiamo prima confermare che sei il proprietario dell\'indirizzo email che ci hai fornito.<br><br>Pertanto ti abbiamo inviato una mail. per favore clicca sul link per convalidare il tuo indirizzo mail e completare con noi la iscrizione del tuo profilo esterno.';

$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_TITLE = 'Iscrizione completata correttamente';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART1 = 'Non esisteva un account Evidence Hub'.$LNG->USER_NAME.' per l\'indirizzo e-mail che ci hai fornito, quindi ora ne abbiamo creato uno e l\'abbiamo associato al tuo profilo '; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART2 = '';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 = '<br>Tuttavia, per completare la iscrizione con noi, dobbiamo prima confermare che sei il proprietario dell\'indirizzo e-mail che ci hai fornito.';
$LNG->LOGIN_EXTERNAL_NO_EMAIL_VERIFICALTION_MESSAGE_PART3 .= '<br><br>'.$LNG->LOGIN_EXTERNAL_EMAIL_VERIFICALTION_MESSAGE;

$LNG->LOGIN_EXTERNAL_WELCOME_TITLE = 'Benvenuto su Evidence Hub';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART1 = 'Non esisteva un account Evidence Hub'.$LNG->USER_NAME.' per l\'indirizzo e-mail:';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART2 = ', quindi ora ne abbiamo creato uno e l\'abbiamo associato al tuo profilo'; // Provder service name will be inserted here .e.g Facebook, Yahoo, Google etc.
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART3 = '.';
$LNG->LOGIN_EXTERNAL_WELCOME_MESSAGE_PART4 = 'A breve dovresti ricevere un\'email di benvenuto.';

$LNG->LOGIN_EXTERNAL_ENTER_BUTTON = 'Entra nel sito';

/** NEW LOGIN ADDITIONS **/
$LNG->LOGIN_ERROR_ACCOUNT_UNVALIDATED = 'L\'account che utilizza i dati di accesso forniti non ha completato il processo di iscrizione. Devi rispondere all\'e-mail che ti è stata inviata per completare la iscrizione, prima di poter accedere.';
$LNG->LOGIN_ERROR_ACCOUNT_UNAUTHORIZED = 'L\'account che utilizza i dati di accesso forniti è in attesa di autorizzazione, quindi non possiamo farti accedere in questo momento.';

$LNG->VALIDATION_COMPLETE_TITLE = 'Convalida indirizzo mail';
$LNG->VALIDATION_FAILED = 'non è stato possibile completare la convalida del tuo indirizzo mail. per favore riprova';
$LNG->VALIDATION_FAILED_INVALID = 'non è stato possibile completare la convalida del tuo indirizzo mail poiché la chiave di convalida non era valida per l\'utente specificato. per favore  riprova';
$LNG->VALIDATION_SUCCESSFUL_LOGIN = "Grazie per aver convalidato il tuo indirizzo mail.</a>";

$LNG->EMAIL_VALIDATE_TEXT = 'Invia nuova email di convalida';
$LNG->EMAIL_VALIDATE_HINT = 'Clicca qui per ricevere un\'altra email di convalida per completare la iscrizione di questo profilo esterno con noi.';
$LNG->EMAIL_VALIDATE_MESSAGE = 'Ti è stata inviata una mail per confermare che possiedi l\'indirizzo email con cui hai provato ad accedere.';

/** ADMIN USER REGISTRATIONMANAGER **/
$LNG->REGSITRATION_ADMIN_MANAGER_LINK = "Richiesta di iscrizione";
$LNG->REGSITRATION_ADMIN_TITLE = 'Manager iscrizione Utente';

$LNG->REGSITRATION_ADMIN_UNREGISTERED_TITLE = "Richiesta di iscrizione";
$LNG->REGSITRATION_ADMIN_UNVALIDATED_TITLE = "iscrizione non convalidata";
$LNG->REGSITRATION_ADMIN_REVALIDATE_BUTTON = "Ri-convalida";
$LNG->REGSITRATION_ADMIN_REMOVE_BUTTON = "Rimuovi ";
$LNG->REGSITRATION_ADMIN_REMOVE_CHECK_MESSAGE = "Sei sicuro di voler cancallare questa  iscrizione utente?: ";
$LNG->REGSITRATION_ADMIN_REVALIDATE_CHECK_MESSAGE = "Sei sicuro di voler inviare un'altra mail di validazione a questo utente?: ";
$LNG->REGSITRATION_ADMIN_USER_REMOVED = 'ha avuto il suo account rimosso dal sistema';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REVALIDATED = 'ha ricevuto conferma della convalida via mail';

$LNG->REGSITRATION_ADMIN_REJECT_CHECK_MESSAGE = "Sei sicuro di voler rigettare la Richiesta di iscrizione di ".$LNG->USER_NAME."?: ";
$LNG->REGSITRATION_ADMIN_ACCEPT_CHECK_MESSAGE = "Sei sicuro di voler accettare la Richiesta di iscrizione di ".$LNG->USER_NAME."?: ";
$LNG->REGSITRATION_ADMIN_NONE_MESSAGE = 'Non ci sono '.$LNG->USERS_NAME.' che richiedono di iscriversi';
$LNG->REGSITRATION_ADMIN_VALIDATION_NONE_MESSAGE = 'Non ci sono utenti in attesa di convalida';
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_DATE = "Data";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_NAME = "Nome";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_DESC = "Descrizione";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_INTEREST = "Interesse";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_WEBSITE = "sito";
$LNG->REGSITRATION_ADMIN_TABLE_HEADING_ACTION = "Azione";
$LNG->REGSITRATION_ADMIN_REJECT_BUTTON = 'Rifiuta';
$LNG->REGSITRATION_ADMIN_ACCEPT_BUTTON = 'Accetta';
$LNG->REGSITRATION_ADMIN_ID_ERROR = "Impossibile elaborare la richiesta dell'utente perché manca l'ID";
$LNG->REGSITRATION_ADMIN_USER_EMAILED_ACCEPTANCE = 'ha ricevuto conferma via email che la sua Richiesta di iscrizione è stata accettata';
$LNG->REGSITRATION_ADMIN_USER_EMAILED_REJECTION = 'ha ricevuto conferma via email che la sua Richiesta di iscrizione è stata rifiutata';
$LNG->REGSITRATION_ADMIN_EMAIL_REQUEST_SUBJECT = $LNG->WELCOME_REGISTER_REQUEST_SUBJECT;

// %s will be replace with the name of the current Evidence Hub. When translating per favore leave this in the sentence appropariately placed.
$LNG->REGSITRATION_ADMIN_EMAIL_REJECT_BODY = 'Grazie per aver richiesto l\'iscrizione su %s.<br>Purtroppo, in questa occasione, la tua richiesta di un account utente non è andata a buon fine.';

/** NEW OPEN COMMENTS CATEGORY **/
$LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR = 'per favore inserisci un'.$LNG->COMMENT_NAME_SHORT.'  prima di provare a pubblicare';
$LNG->FORM_COMMENT_TITLE = 'Aggiungi un nuovo '.$LNG->COMMENT_NAME;
$LNG->FORM_LABEL_COMMENT = $LNG->COMMENT_NAME_SHORT.': ';
$LNG->FORM_COMMENT_MESSAGE = 'Puoi condividere le tue conoscenze con un rapido '.$LNG->COMMENT_NAME_SHORT.'. Successivamente, questo può essere collegato più attentamente nella rete di'.$LNG->EVIDENCE_NAME;
$LNG->FORM_COMMENT_NOT_FOUND = 'Il '.$LNG->COMMENT_NAME.' richiesto non è stato trovato';
$LNG->FORM_COMMENT_CHILD_TITLE = "Usato per costruire:";
$LNG->FORM_COMMENT_PARENT_TITLE = "Costruito da:";
$LNG->BUILT_FROM_ITEM_HINT = 'Vai alla lista '.$LNG->COMMENT_NAME_SHORT.' for per questo '.$LNG->COMMENT_NAME_SHORT;
$LNG->COMMENT_FILTER_ALL = "Tutte le ".$LNG->COMMENT_NAME_SHORT;
$LNG->COMMENT_FILTER_UNUSED = $LNG->COMMENT_NAME_SHORT." non utilizzate";
$LNG->COMMENT_FILTER_USED = $LNG->COMMENT_NAME_SHORT." utilizzate";
$LNG->COMMENT_LOADING_MESSAGE = "Controllo dell\'utilizzo";
$LNG->COMMENT_CONVERT_TO_STORY = 'Trasforma una Storia';
$LNG->COMMENT_CONVERT_TO_STORY_HINT = 'Usa il testo di questo '.$LNG->COMMENT_NAME_SHORT.' per creare';
$LNG->COMMENT_CONVERT_TO_PRACTITIONER_STORY = 'Trasforma una '.$LNG->PRACTITIONER_STORY_NAME;
$LNG->COMMENT_CONVERT_TO_PRACTITIONER_STORY_HINT = 'Usa il testo di questo '.$LNG->COMMENT_NAME_SHORT.' per creare una '.$LNG->PRACTITIONER_STORY_NAME;
$LNG->COMMENT_CONVERT_TO_RESEARCHER_STORY = 'Trasforma una '.$LNG->RESEARCHER_STORY_NAME;
$LNG->COMMENT_CONVERT_TO_RESEARCHER_STORY_HINT = 'Usa il testo di questo '.$LNG->COMMENT_NAME_SHORT.' per creare una '.$LNG->RESEARCHER_STORY_NAME;
$LNG->FORM_COMMENT_STORY_TITLE = 'Costruisci una storia da questo '.$LNG->COMMENT_NAME_SHORT;
$LNG->FORM_COMMENT_PRACTITIONER_STORY_TITLE = 'Costruisci una'.$LNG->PRACTITIONER_STORY_NAME.' da questo '.$LNG->COMMENT_NAME_SHORT;
$LNG->FORM_COMMENT_RESEARCHER_STORY_TITLE = 'Costruisci una'.$LNG->RESEARCHER_STORY_NAME.' da questo '.$LNG->COMMENT_NAME_SHORT;

$LNG->TAB_COMMENT_MESSAGE_LOGGEDIN = "Esplora le ".$LNG->COMMENTS_NAME_SHORT." fatte, e aggiungi le tue.";
$LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_OPEN = "Esplora le".$LNG->COMMENTS_NAME_SHORT." fatti - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registraopen.php'>Sign Up</a> per aggiungere i tuoi.";
$LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_REQUEST = "Esplora le ".$LNG->COMMENTS_NAME_SHORT." fatti - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> | <a title='Sign Up' href='".$CFG->homeAddress."ui/pages/Registrarequest.php'>Sign Up</a> per aggiungere i tuoi.";
$LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_CLOSED = "Esplora le ".$LNG->COMMENTS_NAME_SHORT." fatti - e <a title='Sign In' href='".$CFG->homeAddress."ui/pages/login.php'>Sign In</a> per aggiungere i tuoi.";

$LNG->RECENT_EMAIL_DIGEST_LABEL = 'Resoconto mail:';
$LNG->RECENT_EMAIL_DIGEST_REGISTER_MESSAGE = "Spunta per ricevere un riepilogo e-mail mensile delle attività recenti.";
$LNG->RECENT_EMAIL_DIGEST_PROFILE_MESSAGE = "Attiva/disattiva la ricezione di un riepilogo mensile via email dell'attività recente.";
$LNG->OVERVIEW_COMMENT_MOSTRECENT_TITLE = 'Più recente '.$LNG->COMMENTS_NAME_SHORT;

/** CONNECTION COG MENU OPTION **/
$LNG->CONNECTION_MENU_OPTION_TEXT = 'Aggiungi >>';
$LNG->CONNECTION_MENU_OPTION_HINT = 'Clicca per Mostrare/Nascondere come puoi  connettere questo elemento';
$LNG->CONNECTION_MENU_OPTION_LOGIN_TEXT = 'Accedi per aggiungere';
$LNG->CONNECTION_MENU_OPTION_LOGIN_HINT = 'Devi accedere per poter  aggiungere elementi a questo';
$LNG->DEFAULT_SEARCH_TEXT = 'Inserisci "ricerca per frase" o parole separate';

$LNG->OVERVIEW_HOME_MOSTRECENT_TITLE = 'Ultimi 10';
$LNG->HOME_MOSTRECENT_TITLE = 'Voci più recenti';

$LNG->ALL_ITEMS_FILTER = "Tuttigli gli elementi";
$LNG->CONNECTED_ITEMS_FILTER = "Elementi connessi";
$LNG->UNCONNECTED_ITEMS_FILTER = "Elementi non connessi";

$LNG->SEARCH_TREE_TITLE = 'alberi della conoscenza per cercare risultati su: ';
$LNG->SEARCH_TREE_TITLE_TAGS = 'alberi della conoscenza per cercare risultati per tag: ';
$LNG->SEARCH_NET_TITLE = 'Reti per cercare risultati per: ';
$LNG->SEARCH_NET_TITLE_TAGS = 'Reti per cercare risultati per tag su: ';
$LNG->SEARCH_NET_MESSAGE = "Una ricerca può restituire più reti.<br>Premi il pulsante \"Metti in pausa lo spostamento del grafico\" o il pulsante \"Appunta tutti i nodi\" (lucchetto chiuso) per impedire che reti separate si allontanino troppo.<br>Premi il pulsante \'Adatta allo schermo\' per vederli tutti insieme.";

$LNG->GRAPH_PRINT_HINT = "Stampa questo grafico di rete ";
$LNG->GRAPH_ZOOM_FIT_HINT = "Ridimensiona il grafico se necessario e spostalo per adattarlo all\'area visibile";
$LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT = "Ingrandisci questo grafico di rete al 100% e centra l\'elemento focale";
$LNG->GRAPH_ZOOM_IN_HINT = "Ingrandisci";
$LNG->GRAPH_ZOOM_OUT_HINT = "Riduci";
$LNG->GRAPH_CONNECTION_COUNT_LABEL = 'Numero di connessioni:';
$LNG->GRAPH_NOT_SUPPORTED = 'Il tuo browser attuale non supporta HTML5 Canvas.<br><br>per favore, aggiorna a una versione più recente se lo desideri per visualizzare questo grafico di rete: IE 9.0+; Firefox 23.0+; Chrome 29.0+; Opera 17.0+; Safari 5.1+';

$LNG->USER_PROFILE_TAG_USAGE = "Hai utilizzato questo tag nel tuo profilo utente.";
$LNG->FORM_REMOVE_MULTI = "Sei sicuro di voler rimuovere questo elemento? Questa azione non può essere annullata!";

$LNG->USER_REPORT_MY_DATA_TITLE = 'I miei contributi al'.$CFG->SITE_TITLE;
$LNG->USER_REPORT_MY_DATA_LINK = 'Stampa i miei contributi';
$LNG->USER_REPORT_MY_DATA_LINK_HINT = 'Visualizza un rapporto che mostra i contributi che questo'.$LNG->USER_NAME.' ha apportato al '.$CFG->SITE_TITLE;

$LNG->CORE_DATAMODEL_GROUP_CANNOT_REMOVE_MEMBER = 'Non può cancellare '.$LNG->USER_NAME.' come amministratore perché il gruppo non avrà amministratori';


/**********************************************/
/** NEW PROPERTIES FOR DEBATE VIEW CODE ETC. **/
/**********************************************/

$LNG->NODE_EDIT_SOLUTION_ICON_HINT = 'Modifica questa '.$LNG->SOLUTION_NAME;

$LNG->FORM_IDEA_NEW_TITLE = "Aggiungi la tua ".$LNG->SOLUTION_NAME;
$LNG->FORM_IDEA_LABEL_TITLE = "Titolo ".$LNG->SOLUTION_NAME."...";
$LNG->FORM_IDEA_LABEL_DESC = "Descrizione ".$LNG->SOLUTION_NAME."...";

$LNG->FORM_PRO_LABEL_TITLE = "Titolo ".$LNG->PRO_NAME."...";
$LNG->FORM_PRO_LABEL_DESC = "Descrizione ".$LNG->PRO_NAME."...";
$LNG->FORM_CON_LABEL_TITLE = "Titolo ".$LNG->CON_NAME." ...";
$LNG->FORM_CON_LABEL_DESC = "Descrizione ".$LNG->CON_NAME."...";
$LNG->FORM_LINK_LABEL = "Incolla".$LNG->RESOURCE_NAME."...";
$LNG->FORM_MORE_LINKS_BUTTONS = "Aggiungi un'altra ".$LNG->RESOURCE_NAME;
$LNG->FORM_DELETE_LINKS_BUTTONS = "Cancella";
$LNG->FORM_LINK_INVALID_PART1 = "L'url: ";
$LNG->FORM_LINK_INVALID_PART2 = ", non è valido. Assicurati che inizi con https:// o un altro protocollo web valido";
$LNG->EXPLORE_EDITING_ARGUMENT_TITLE = "Modifica";

$LNG->FORM_EVIDENCE_RESOURCE_TITLE = "Titolo della risorsa";
$LNG->FORM_EVIDENCE_RESOURCE_DOI = "Identificatore di oggetti digitali (DOI) per la pubblicazione, se noto";

$LNG->FORM_BUTTON_SUBMIT = 'Inoltra';

$LNG->IDEA_ARGUMENTS_LINK = $LNG->EVIDENCES_NAME;
$LNG->IDEA_ARGUMENTS_HINT = 'Visualizza e aggiungi una '.$LNG->EVIDENCES_NAME.' su questa '.$LNG->SOLUTION_NAME;

$LNG->FORM_PRO_ENTER_SUMMARY_ERROR = 'Per favore inserisci un titolo per il tuo'.$LNG->PRO_NAME.' prima di provare a inoltrare';
$LNG->FORM_CON_ENTER_SUMMARY_ERROR = 'per favore inserisci un titolo per il tuo '.$LNG->CON_NAME.' prima di provare a inoltrare';

$LNG->SORT_RANDOM = "Random";

$LNG->DEBATE_CONTRIBUTE_LINK_TEXT = "Contribuisci";
$LNG->DEBATE_CONTRIBUTE_LINK_HINT = "Aggiungi un ".$LNG->ARGUMENT_NAME." a questa ".$LNG->SOLUTION_NAME;

$LNG->SOLUTION_CREATE_LOGGED_OUT_OPEN = "per contribuire a questo ".$LNG->DEBATE_NAME;
$LNG->SOLUTION_CREATE_LOGGED_OUT_REQUEST = "per contribuire a questo ".$LNG->DEBATE_NAME;
$LNG->SOLUTION_CREATE_LOGGED_OUT_CLOSED = "per contribuire a questo ".$LNG->DEBATE_NAME;

$LNG->VIEWS_DEBATE_MAP_HINT="Clicca per visualizzare il ".$LNG->DEBATE_NAME." per questo elemento";

$LNG->ISSUELIST_ITEM_HINT="Contribuisci a questo ".$LNG->ISSUE_NAME;

// FORM CHANGES ADDED ORGS AND PROJECTS

$LNG->FORM_EDIT_COMMENT_TITLE = 'Modifica questa '.$LNG->COMMENT_NAME;

$LNG->FORM_PROJECT_SELECT_EXISTING = 'Aggiungi un '.$LNG->PROJECT_NAME_SHORT.' esistente';
$LNG->FORM_ORG_SELECT_EXISTING = 'Aggiungi un '.$LNG->ORG_NAME_SHORT.' esistente';
$LNG->FORM_EVIDENCE_SELECT_EXISTING = 'Aggiungi un '.$LNG->EVIDENCE_NAME.' esistente';

$LNG->EVIDENCE_PROJECT_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->PROJECTS_NAME.' associato a questo '.$LNG->EVIDENCE_NAME.'. Puoi inserirne più di uno.';
$LNG->EVIDENCE_ORG_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->ORGS_NAME.' associato a questo '.$LNG->EVIDENCE_NAME.'. Puoi inserirne più di uno.';

$LNG->RESOURCE_PROJECT_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->PROJECTS_NAME.' associato a questa '.$LNG->RESOURCE_NAME.'. Puoi inserirne più di uno.';
$LNG->RESOURCE_ORG_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->ORGS_NAME.' associato a questa '.$LNG->RESOURCE_NAME.'. Puoi inserirne più di uno.';

$LNG->COMMENT_PROJECTS_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->PROJECTS_NAME.' associato a questo '.$LNG->COMMENT_NAME.'. Puoi inserirne più di uno.';
$LNG->COMMENT_ORGS_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->ORGS_NAME.' associato a questo '.$LNG->COMMENT_NAME.'. Puoi inserirne più di uno.';
$LNG->COMMENT_EVIDENCE_FORM_HINT = '(opzionale) - Aggiungi qualsiasi '.$LNG->EVIDENCES_NAME.' associato a questo '.$LNG->COMMENT_NAME.'. Puoi inserirne più di uno.';

$LNG->ORG_PROJECTS_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->PROJECTS_NAME.' connesso. Puoi inserirne più di uno.';
$LNG->ORG_ORGS_FORM_HINT = '(opzionale)  - Aggiungi qualsiasi '.$LNG->ORGS_NAME.' connesso. Puoi inserirne più di uno.';

$LNG->DEBATE_NOT_AVAILABLE = "La visualizzazione del dibattito non è disponibile su questa istanza di Evidence Hub";

$LNG->DEBATE_ADD_EVIDENCE_PRO_HEADING = 'Aggiungi un '.$LNG->EVIDENCE_NAME.' di supporto';
$LNG->DEBATE_ADD_EVIDENCE_CON_HEADING = 'Aggiungi un '.$LNG->EVIDENCE_NAME. 'contatore';
?>
