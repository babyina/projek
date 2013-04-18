<?php

//------------------------------------------------------------------------------
// Czech language file from Dan Barta (Enemy) and Jan Kincl
// encoding:          ----------> iso-8859-2 <----------
//------------------------------------------------------------------------------

//'keyword' => 'translation'
$phpdig_mess = array (
'mode'          =>'mode',
'query'         =>'query',
'list_meanings' =>'� Total - lists the total number of searches for each query
� Query - lists the various keywords for each search query
� Mode - lists the "and, exact, or" search mode per query
� Links - lists the average number of links found per query
� Time - lists the most recent GMT timestamp of each query',
'with_no_results' =>'with no results',
'with_results' =>'with results',
'searches'     =>'searches',
'page'         =>'Page',
'of'           =>'of',
'to'           =>'to',
'listing'      =>'Listing',
'viewList'     =>'View List of Queries',
'one_per_line' =>'Enter one link per line',

'StopSpider'   =>'Stop spider',
'id'           =>'ID',
'url'          =>'URL',
'days'         =>'Days',
'links'        =>'Links',
'depth'        =>'Depth',
'viewRSS'      =>'View RSS for this Page',
'powered_by'   =>'Powered by PhpDig',
'searchall'    =>'Search All',
'wait'         =>'Wait... ',
'done'         =>'Done!',
'limit'        =>'Limit',
'manage'       =>'Here you can manage:',
'dayscron'     =>'- the number of <b>days</b> crontab waits to reindex (0 = ignore)',
'links_mean'   =>'- the max number of <b>links</b> per depth per site (0 = unlimited)',
'depth_mean'   =>'- the max search <b>depth</b> per site (0 = none, depth trumps links)',
'max_found'    =>'Maximum links found is ((links * depth) + 1) when links is greater than zero.',
'default_vals' =>'Default values',
'use_vals_from' =>'Use values from',
'table_present' =>'table if present and use<br/>default values if values absent from table?',
'admin_msg_1'   =>'- To empty tempspider table click delete button <i>without</i> selecting a site',
'admin_msg_2'   =>'- Search depth of zero tries to crawl just that page regardless of links per',
'admin_msg_3'   =>'- Set links per depth to the max number of links to check at each depth',
'admin_msg_4'   =>'- Links per depth of zero means to check for all links at each seach depth',
'admin_msg_5'   =>'- Clean dashes removes \'-\' index pages from blue arrow listings of pages',
'admin_panel'   =>'Admin Panel',

'choose_temp'  =>'Choose a template',
'select_site'  =>'Select a site to search',
'restart'      =>'Restart',
'narrow_path'  =>'Narrow Path to Search',
'upd_sites'    =>'Update sites',
'upd2'         =>'Update Done',
'links_per'    =>'Links per',
'yes'          =>'ano',
'no'           =>'ne',
'delete'       =>'smazat',
'reindex'      =>'p�eindexovat',
'back'         =>'zp�t',
'files'        =>'soubory',
'admin'        =>'administrace',
'warning'      =>'Pozor!',
'index_uri'    =>'Kter� URI chcete indexovat?',
'spider_depth' =>'Hloubka vyhled�v�n�',
'spider_warn'  =>'Pros�m ov��te, zda adresa nebyla ji� indexov�na.
Uzamykac� mechanismus bude k dispozici pozd�ji.',
'site_update'  =>'aktualizace str�nky nebo v�tve webu',
'clean'        =>'�istit',
't_index'      =>'Index',
't_dic'        =>'slovn�k',
't_stopw'      =>'b�n� slova',
't_dash'       =>'dashes',

'update'       =>'aktualizace',
'exclude'      =>'vymazan� a vy�azen� v�tev',
'excludes'     =>'vy�azen� cesty',
'tree_found'   =>'Vyhled�v�n� stromu',
'update_mess'  =>'p�eindexov�n� nebo smaz�n� stromu?',
'update_warn'  =>'v�maz je trval�',
'update_help'  =>'Kliknut�m na k���ek vyma�ete v�tev
Kliknut�m na zelenou te�ku povol�te aktualizaci
Kliknut�m na jednosm�rku vylou��te z budouc�ch aktualizac�',
'branch_start' =>'Vyberte slo�ku kliknut�m na modrou �ipku v lev� ��sti obrazovky.',
'branch_help1' =>'Vyberte dokumentu k jednotliv� aktualizaci',
'branch_help2' =>'Kliknut�m na k���ek vyma�ete dokumenty,
kliknut�m na zelenou te�ku aktualizujete dokument',
'redepth'      =>'�rove�',
'branch_warn'  =>'vymaz�n� je trval�, bez n�vratu',
'to_admin'     =>'k administratorsk�mu rozhran�',
'to_update'    =>'k aktualiza�n�mu rozhran�',

'search'       =>'Kl��ov� slova',
'results'      =>'v�sledk�',
'display'      =>'zobraz',
'w_begin'      =>'slovo za��n� na',
'w_whole'      =>'p�esn� zn�n� slova',
'w_part'       =>'jak�koliv ��st slov',
'alt_try'      =>'Did you mean',

'limit_to'     =>'limit po',
'this_path'    =>'tato cesta',
'total'        =>'celkem',
'seconds'      =>'sekundy',
'w_common_sing'     =>'p��li� velk� mno�stv� kl��ov�ch slov.',
'w_short_sing'      =>'p��li� kr�tk� slova byla ignorov�na.',
'w_common_plur'     =>'p��li� velk� mno�stv� kl��ov�ch slov.',
'w_short_plur'      =>'p��li� kr�tk� slova byla ignorov�na.',
's_results'    =>'v�sledky hled�n�',
'previous'     =>'p�edchoz�',
'next'         =>'dal��',
'on'           =>'hledan� slova:',

'id_start'     =>'Str�nka indexov�na',
'id_end'       =>'Indexace kompletn�!',
'id_recent'    =>'Pr�v� bylo indexov�no',
'num_words'    =>'Po�et slov',
'time'         =>'�as',
'error'        =>'chyba',
'no_spider'    =>'Spider nebyl spu�t�n',
'no_site'      =>'tato strana nenalezena v datab�zi',
'no_temp'      =>'��dn� odkazy v do�asn� tabulce',
'no_toindex'   =>'��dn� data k indexaci',
'double'       =>'duplicitn� odkaz na ji� existuj�c� dokument',

'spidering'    =>'Spider pr�v� pracuje...',
'links_more'   =>'dal�� nov� odkazy',
'level'        =>'�rove�',
'links_found'  =>'nalezeny odkazy',
'define_ex'    =>'Definice v�jimek',
'index_all'    =>'V�echno zaindexov�no',

'end'          =>'Konec',
'no_query'     =>'Pros�m vypl�te vyhled�vac� pole',
'pwait'        =>'pros�m �ekejte',
'statistics'   =>'statistika',

// INSTALL
'slogan'   =>'Nejmen�� vyhled�vac� n�stroj na sv�t�. : verze',
'installation'   =>'Instalace',
'instructions' =>'Zde napi�te parametry MySql. Ur�ete platn�ho u�ivatele, kter� m��e vytv��et datab�ze, pokud se rozhodnete je tvo�it nebo m�nit.',
'hostname'   =>'Hostname  :',
'port'   =>'Port (pr�zdn� = default) :',
'sock'   =>'Sock (pr�zdn� = default) :',
'user'   =>'U�ivatel :',
'password'   =>'Heslo :',
'phpdigdatabase'   =>'PhpDig datab�ze :',
'tablesprefix'   =>'P�edpona tabulek :',
'instructions2'   =>'* voliteln�. Pou�ijte mal� p�smena, 16 p�smen maxim�ln�',
'installdatabase'   =>'Instalovat phpdig datab�ze',
'error1'   =>'Nemohu naj�t p�ipojovac� �ablonu. ',
'error2'   =>'Nemohu zapsat p�ipojovac� �ablonu. ',
'error3'   =>'Nemohu naj�t soubor init_db.sql. ',
'error4'   =>'Nemohu vytvo�it tabulky. ',
'error5'   =>'Nemohu naj�t v�echny konfigura�n� soubory datab�zez. ',
'error6'   =>'Nemohu vytvo�it datab�zi.<br />Ov��te pr�va u�ivatele. ',
'error7'   =>'Nemohu se spojit s datab�z�.<br />Ov��te p�ihla�ovac� �daje. ',
'createdb' =>'Vytvo�it datab�zi',
'createtables' =>'Vytvo�it pouze tabulky',
'updatedb' =>'Zm�nit existuj�c� datab�zi',
'existingdb' =>'Pouze vypsat parametry p�ipojen�',
// CLEANUP_ENGINE
'cleaningindex'   =>'�ist�m seznam',
'enginenotok'   =>' seznam odkaz� ukazuje na neexistuj�c� kl��ov� v�raz.',
'engineok'   =>'Engine je koherentn�.',
// CLEANUP_KEYWORDS
'cleaningdictionnary'   =>'�ist�m slovn�ky',
'keywordsok'   =>'V�echny kl��ov� v�razy jsou na jedn� nebo v�ce str�nk�ch.',
'keywordsnotok'   =>' kl��ov� v�razy nebyly ani na j�dn� str�nce.',
// CLEANUP_COMMON
'cleanupcommon' =>'Vy�istit b�n� slova',
'cleanuptotal' =>'Celkem ',
'cleaned' =>' vy�i�t�no.',
'deletedfor' =>' smaz�no za ',
// INDEX ADMIN
'digthis' =>'Indexuj !',
'databasestatus' =>'Stav datab�ze',
'entries' =>' Polo�ek ',
'updateform' =>'Aktualiza�n� formul��',
'deletesite' =>'Smazat str�nku',
// SPIDER
'spiderresults' =>'V�sledky spideringu',
// STATISTICS
'mostkeywords' =>'Nejhledanej�� kl��ov� slova',
'richestpages' =>'Nejbohat�� str�nky',
'mostterms'    =>'Nejpou��vanej�� podm�nky',
'largestresults'=>'Nejv�t�� v�sledky',
'mostempty'     =>'Nejv�c hled�n� bez v�sledku',
'lastqueries'   =>'Posledn� hledan� dotazy',
'responsebyhour'=>'Response time by hour',
// UPDATE
'userpasschanged' =>'U�ivatel/Heslo zm�n�no !',
'uri' =>'URI : ',
'change' =>'Zm�nit',
'root' =>'Ko�en',
'pages' =>' str�nek',
'locked' => 'Zamknuto',
'unlock' => 'Odemkout str�nku',
'onelock' => 'Str�nka je zamknuta, prob�h� spidering. Akci nelze nyn� prov�st',
// PHPDIG_FORM
'go' =>'Hledej',
// SEARCH_FUNCTION
'noresults' =>'BEZ V�SLEDKU'
);
?>