<?php
/**
 * Events Component for Joomla 1.0.x
 * Finnish language file for JEvents 1.4
 * Author: Kari Söderholm, updated to version 1.4
 * Author: Markku Suominen, original traslation of the events component
 * Email: admin@joomlaportal.fi, www.joomlaportal.fi
 * @version     $Id: finnish-utf8.php 991 2008-03-10 19:55:48Z tstahl $
 * @package     Events
 * @copyright   Copyright (C) 2006-2008 JEvents Project Group
 * @licence     http://www.gnu.org/copyleft/gpl.html
 * @link        http://joomlacode.org/gf/project/jevents
 * @encoding    utf-8
 */

defined("_VALID_MOS") or die("Direct Access to this location is not allowed");

//Check
DEFINE("_CAL_LANG_INCLUDED", 1);

// new 1.4.0 [mic]
define("_CAL_LANG_LNG",				"fi"); // de|fr|etc... [ DO NOT CHANGE THIS VALUE! ]

// used for colorpicker
define("_CAL_LANG_NO_COLOR",			"Ei väriä");
define("_CAL_LANG_COLOR_PICKER",		"Värivalitsin");

// common
define("_CAL_LANG_TIME",				"Aika");
define("_CAL_LANG_CLICK_TO_OPEN_EVENT",	"Napsauta siirtyäksesi tapahtumaan");
define("_CAL_LANG_UNPUBLISHED",		"** Julkaisematon **");
define("_CAL_LANG_DESCRIPTION",		"Kuvaus");
define("_CAL_LANG_EMAIL_TO_AUTHOR",	"Lähetä sähkäpostia tekijälle");
define("_CAL_LANG_MAIL_TO_ADMIN",		"Tapahtuma lähetetty sivulta [ %s ] Lähettäjä: [ %s ]");
define("_CAL_LANG_KEYWORD_NOT_VALID",	"Hakusana ei kelpaa");
define("_CAL_LANG_EVENT_CALENDAR",		"Events kalenteri"); // new 1.4

// modul
define("_CAL_LANG_ERR_NO_MOD_CAL",		"Events kalenteri\n<br />Tämä moduuli tarvitsee Events komponentin toimiakseen");
define("_CAL_LANG_CLICK_TOSWITCH_DAY",	"Siirry kalenteriin - tämä päivä");
define("_CAL_LANG_CLICK_TOSWITCH_MON",	"Siirry kalenteriin - tämä kuukausi");
define("_CAL_LANG_CLICK_TOSWITCH_YEAR",	"Siirry kalenteriin - tämä vuosi");
define("_CAL_LANG_CLICK_TOSWITCH_PY",	"Siirry kalenteriin - edellinen vuosi");
define("_CAL_LANG_CLICK_TOSWITCH_PM",	"Siirry kalenteriin - edellinen kuukausi");
define("_CAL_LANG_CLICK_TOSWITCH_NM",	"Siirry kalenteriin - seuraava kuukausi");
define("_CAL_LANG_CLICK_TOSWITCH_NY",	"Siirry kalenteriin - seuraava vuosi");

// navTableNext
define("_CAL_LANG_NAV_TN_FIRST_LIST",	"ensimmäinen lista");
define("_CAL_LANG_NAV_TN_PREV_LIST",	"edellinen lista");
define("_CAL_LANG_NAV_TN_NEXT_LIST",	"seuraava lista");
define("_CAL_LANG_NAV_TN_LAST_LIST",	"viimeinen lista");

// calendar monthly display
define("_CAL_LANG_FIRST_SINGLE_DAY_EVENT",		"Yksittäinen tapahtuma");
define("_CAL_LANG_FIRST_DAY_OF_MULTIEVENT",	"Monipäiväisen tapahtuman ensimmäinen päivä");
define("_CAL_LANG_LAST_DAY_OF_MULTIEVENT",		"Monipäiväisen tapahtuman viimeinen päivä");
define("_CAL_LANG_MULTIDAY_EVENT",				"Monipäiväinen tapahtuma");
/* ++++++ end mic +++++++++++++ */

// Months
DEFINE("_CAL_LANG_JANUARY", "Tammikuu");
DEFINE("_CAL_LANG_FEBRUARY", "Helmikuu");
DEFINE("_CAL_LANG_MARCH", "Maaliskuu");
DEFINE("_CAL_LANG_APRIL", "Huhtikuu");
DEFINE("_CAL_LANG_MAY", "Toukokuu");
DEFINE("_CAL_LANG_JUNE", "Kesäkuu");
DEFINE("_CAL_LANG_JULY", "Heinäkuu");
DEFINE("_CAL_LANG_AUGUST", "Elokuu");
DEFINE("_CAL_LANG_SEPTEMBER", "Syyskuu");
DEFINE("_CAL_LANG_OCTOBER", "Lokakuu");
DEFINE("_CAL_LANG_NOVEMBER", "Marraskuu");
DEFINE("_CAL_LANG_DECEMBER", "Joulukuu");

// Short day names
DEFINE("_CAL_LANG_SUN", "Su");
DEFINE("_CAL_LANG_MON", "Ma");
DEFINE("_CAL_LANG_TUE", "Ti");
DEFINE("_CAL_LANG_WED", "Ke");
DEFINE("_CAL_LANG_THU", "To");
DEFINE("_CAL_LANG_FRI", "Pe");
DEFINE("_CAL_LANG_SAT", "La");

// Days
DEFINE("_CAL_LANG_SUNDAY", "Sunnuntai");
DEFINE("_CAL_LANG_MONDAY", "Maanantai");
DEFINE("_CAL_LANG_TUESDAY", "Tiistai");
DEFINE("_CAL_LANG_WEDNESDAY", "Keskiviikko");
DEFINE("_CAL_LANG_THURSDAY", "Torstai");
DEFINE("_CAL_LANG_FRIDAY", "Perjantai");
DEFINE("_CAL_LANG_SATURDAY", "Lauantai");

// Days lettres
DEFINE("_CAL_LANG_SUNDAYSHORT", "S");
DEFINE("_CAL_LANG_MONDAYSHORT", "M");
DEFINE("_CAL_LANG_TUESDAYSHORT", "T");
DEFINE("_CAL_LANG_WEDNESDAYSHORT", "K");
DEFINE("_CAL_LANG_THURSDAYSHORT", "T");
DEFINE("_CAL_LANG_FRIDAYSHORT", "P");
DEFINE("_CAL_LANG_SATURDAYSHORT", "L");

// Repeat type
DEFINE("_CAL_LANG_ALLDAYS", "Yksittäinen tapahtuma");
DEFINE("_CAL_LANG_EACHWEEK", "Kerran viikossa");
DEFINE("_CAL_LANG_EACHWEEKPAIR", "Joka parillinen viikko");
DEFINE("_CAL_LANG_EACHWEEKIMPAIR", "Joka pariton viikko");
DEFINE("_CAL_LANG_EACHMONTH", "Joka kuukausi");
DEFINE("_CAL_LANG_EACHYEAR", "Joka vuosi");
DEFINE("_CAL_LANG_ONLYDAYS", "Vain valittuina päivinä");
DEFINE("_CAL_LANG_EACH", "Joka");
DEFINE("_CAL_LANG_EACHOF","jokainen");
DEFINE("_CAL_LANG_ENDMONTH", "kuukauden lopussa");

// Repeat days
DEFINE("_CAL_LANG_BYDAYNUMBER", "Päivän numeron mukaan");

// User type
DEFINE("_CAL_LANG_ANONYME", "Nimetön");

// Post
//PAS D'ACCENTS DANS LES _ACT_
DEFINE("_CAL_LANG_ACT_ADDED", "Kiitos viestistäsi - vahvistamme ehdotuksesi!"); //NO ACCENT !!
DEFINE("_CAL_LANG_ACT_MODIFIED", "Tapahtumaa on muokattu."); //NO ACCENT !!
DEFINE("_CAL_LANG_ACT_PUBLISHED", "Tapahtuma on julkaistu.");  //NEW 1.4
DEFINE("_CAL_LANG_ACT_DELETED", "Tapahtuma on poistettu!"); //NO ACCENT !!
DEFINE("_CAL_LANG_NOPERMISSION", "Sinulla ei ole käyttöoikeuksia tälle sivustolle!"); //NO ACCENT !!

DEFINE("_CAL_LANG_MAIL_ADDED", "Uusi viesti lähtien");
DEFINE("_CAL_LANG_MAIL_MODIFIED", "Uusi muutos lähtien");

// Presentation
DEFINE("_CAL_LANG_BY", "Lisännyt");
DEFINE("_CAL_LANG_FROM", "Alkaa");
DEFINE("_CAL_LANG_TO", "Loppuu");
DEFINE("_CAL_LANG_ARCHIVE", "Arkistot");
DEFINE("_CAL_LANG_WEEK", "viikko");
DEFINE("_CAL_LANG_NO_EVENTS", "Ei tapahtumia");
DEFINE("_CAL_LANG_NO_EVENTFOR", "Ei tapahtumia ajanjaksolla");
DEFINE("_CAL_LANG_NO_EVENTFORTHE", "Ei tapahtumia");
DEFINE("_CAL_LANG_THIS_DAY", "tämä päivä");
DEFINE("_CAL_LANG_THIS_MONTH", "Tämä kuukausi");
DEFINE("_CAL_LANG_LAST_MONTH", "Edellinen kuukausi");
DEFINE("_CAL_LANG_NEXT_MONTH", "Seuraava kuukausi");
DEFINE("_CAL_LANG_EVENTSFOR", "Tapahtumat ajalla - ");
DEFINE("_CAL_LANG_SEARCHRESULTS", "Hakutulokset hakusanalla"); // new 1.4
DEFINE("_CAL_LANG_EVENTSFORTHE", "Tapahtumat ajalla - ");
DEFINE("_CAL_LANG_REP_DAY", "päivä");
DEFINE("_CAL_LANG_REP_WEEK", "viikko");
DEFINE("_CAL_LANG_REP_WEEKPAIR", "joka toinen viikko");
DEFINE("_CAL_LANG_REP_WEEKIMPAIR", "joka kolmas viikko");
DEFINE("_CAL_LANG_REP_MONTH", "kuukausi");
DEFINE("_CAL_LANG_REP_YEAR", "vuosi");
DEFINE("_CAL_LANG_REP_NOEVENTSELECTED", "Valitse tapahtuma");

// Navigation
DEFINE("_CAL_LANG_VIEWTODAY", "Tänään");
DEFINE("_CAL_LANG_VIEWTOCOME", "Tulossa tässä kuussa");
DEFINE("_CAL_LANG_VIEWBYDAY", "Päivänäkymä");
DEFINE("_CAL_LANG_VIEWBYCAT", "Katso kategorioittain");
DEFINE("_CAL_LANG_VIEWBYMONTH", "Kuukausinäkymä");
DEFINE("_CAL_LANG_VIEWBYYEAR", "Vuosinäkymä");
DEFINE("_CAL_LANG_VIEWBYWEEK", "Viikkonäkymä");
DEFINE("_CAL_LANG_JUMPTO", "Siirry tiettyyn kuukauteen");  // New 1.4
DEFINE("_CAL_LANG_BACK", "Takaisin");
DEFINE("_CAL_LANG_CLOSE", "Sulje");
DEFINE("_CAL_LANG_PREVIOUSDAY", "Edellinen päivä");
DEFINE("_CAL_LANG_PREVIOUSWEEK", "Edellinen viikko");
DEFINE("_CAL_LANG_PREVIOUSMONTH", "Edellinen kuukausi");
DEFINE("_CAL_LANG_PREVIOUSYEAR", "Edellinen vuosi");
DEFINE("_CAL_LANG_NEXTDAY", "Seuraava päivä");
DEFINE("_CAL_LANG_NEXTWEEK", "Seuraava viikko");
DEFINE("_CAL_LANG_NEXTMONTH", "Seuraava kuukausi");
DEFINE("_CAL_LANG_NEXTYEAR", "Seuraava vuosi");

DEFINE("_CAL_LANG_ADMINPANEL", "Ylläpito");
DEFINE("_CAL_LANG_ADDEVENT", "Lisää tapahtuma");
DEFINE("_CAL_LANG_MYEVENTS", "Omat tapahtumat");
DEFINE("_CAL_LANG_DELETE", "Poista");
DEFINE("_CAL_LANG_MODIFY", "Muokkaa");

// Form
DEFINE("_CAL_LANG_HELP", "Ohje");

DEFINE("_CAL_LANG_CAL_TITLE", "Tapahtumat");
DEFINE("_CAL_LANG_ADD_TITLE", "Lisää");
DEFINE("_CAL_LANG_MODIFY_TITLE", "Muokkaa");

DEFINE("_CAL_LANG_EVENT_TITLE", "Aihe");
DEFINE("_CAL_LANG_EVENT_COLOR", "Väri");
DEFINE("_CAL_LANG_EVENT_CATCOLOR", "Käytä kategorian väriä");
DEFINE("_CAL_LANG_EVENT_CATEGORY", "Kategoria");
DEFINE("_CAL_LANG_EVENT_CHOOSE_CATEG", "Valitse kategoria");
DEFINE("_CAL_LANG_EVENT_ACTIVITY", "Tapahtuman kuvaus");
DEFINE("_CAL_LANG_EVENT_URLMAIL_INFO", "Lisää  www- tai sähköpostiosoite kirjoittamallla esim. <u>http://www.yle.fi</u> tai <u>info@yle.fi</u>");
DEFINE("_CAL_LANG_EVENT_ADRESSE", "Sijainti");
DEFINE("_CAL_LANG_EVENT_CONTACT", "Yhteyshenkilä");
DEFINE("_CAL_LANG_EVENT_EXTRA", "Lisätietoa");
DEFINE("_CAL_LANG_EVENT_AUTHOR_ALIAS", "Kirjoittanut (alias)");
DEFINE("_CAL_LANG_EVENT_STARTDATE", "Aloituspäivä");
DEFINE("_CAL_LANG_EVENT_ENDDATE", "Lopetuspäivä");
DEFINE("_CAL_LANG_EVENT_STARTHOURS", "Aloitus (tunti)");
DEFINE("_CAL_LANG_EVENT_ENDHOURS", "Lopetus (tunti)");
DEFINE("_CAL_LANG_EVENT_STARTTIME", "Aloitusaika");
DEFINE("_CAL_LANG_EVENT_ENDTIME", "Lopetusaika");
DEFINE("_CAL_LANG_PUB_INFO", "Julkaisupäivä");
DEFINE("_CAL_LANG_EVENT_REPEATTYPE", "Toistotyyppi");
DEFINE("_CAL_LANG_EVENT_REPEATDAY", "Toistopäivä");
DEFINE("_CAL_LANG_EVENT_CHOOSE_WEEKDAYS", "Päiviä viikossa");
DEFINE("_CAL_LANG_EVENT_PER", "joka");
DEFINE("_CAL_LANG_EVENT_WEEKOPT", "Kuukauden viikko (viikot)");

DEFINE("_CAL_LANG_SUBMITPREVIEW", "Esikatsele");
DEFINE("_CAL_LANG_SUBMITCANCEL", "Peru");
DEFINE("_CAL_LANG_SUBMITSAVE", "Tallenna");

DEFINE("_CAL_LANG_E_WARNWEEKS", "Valitse viikko.");
DEFINE("_CAL_LANG_E_WARNDAYS", "Valitse päivä.");

// Admin
DEFINE("_CAL_LANG_EVENT_ALLCAT", "Kaikki kategoriat");
DEFINE("_CAL_LANG_EVENT_ACCESSLEVEL", "Käyttäoikeustaso");
DEFINE("_CAL_LANG_EVENT_HITS", "Osumia");
DEFINE("_CAL_LANG_EVENT_STATE", "Tila");
DEFINE("_CAL_LANG_EVENT_CREATED", "Luotu");
DEFINE("_CAL_LANG_EVENT_NEWEVENT", "Uusi tapahtuma");
DEFINE("_CAL_LANG_EVENT_MODIFIED", "Viimeksi muokattu");
DEFINE("_CAL_LANG_EVENT_NOTMODIFIED", "Ei muokattu");

// dmcd aug 22/04  new warning alert for no specified activity in event entry
DEFINE("_CAL_LANG_WARNACTIVITY", "Tapahtumalla pitää\\nolla kuvaus.");

DEFINE("_CAL_LEGEND_ALL_CATEGORIES", "Kaikki kategoriat ...");  // new for 1.4
DEFINE("_CAL_LEGEND_ALL_CATEGORIES_DESC", "Näytä kaikkien kategorioiden tapahtumat");  // new for 1.4

DEFINE("_CAL_LANG_FORM_HELP_COLOR", <<<END
        <tr>
		  <td width="110" align="left" valign="top">
            <b>V&auml;ri</b>
          </td>
          <td>Valitse tapahtumalle taustav&auml;ri, joka n&auml;kyy kalenterin kuukausin&auml;kym&auml;ss&auml;.  Jos Kategoria valintaruutu on valittu,
		  oletusv&auml;rin&auml; on valitun kategorian v&auml;ri (sivuston yll&auml;pit&auml;j&auml;n m&auml;&auml;rittelem&auml;), ja 'V&auml;rivalitsin' on pois k&auml;yt&ouml;st&auml;.</td>
        </tr>
END
);

DEFINE("_CAL_LANG_FORM_HELP",  <<<END
    	<tr>
          <td align="left"><b>Päivämäärä</b></td>
          <td>Valitse tapahtumasi aloitus- ja lopetuspäivämäärä.</td>
        </tr>
    	<tr>
          <td align="left" valign="top"><b>Aika</b></td>
          <td>Valitse tapahtuman aika.  Muoto on <span style='color:blue;font-weight:bold;'>hh:mm {am|pm}</span>.<br/>Aika voidaan m&auml;&auml;ritt&auml;&auml; 12 tai 24 tunnin muodossa.<br/><br/><b><i><span style='color:red;'>(Uutta)</span></i> Huomaa</b> ett&auml; <span style='color:red;font-weight:bold;'>yhden p&auml;iv&auml;n tapahtumat, jotka kest&auml;v&auml;t yli keskiy&ouml;n</span> ovat erikoistapaus.  Esim. Yhden p&auml;iv&auml;n tapahtumalle, joka alkaa 19:00 ja p&auml;&auml;ttyy 03:00, aloitus- ja lopetuspäivämäärien <b>TULEE</b> olla&nbsp;
		   sama p&auml;iv&auml;m&auml;&auml;r&auml;, ja sen tulisi olla p&auml;iv&auml;m&auml;&auml;r&auml; ennen keskiy&ouml;t&auml;.</td>
        </tr>
END
);

DEFINE("_CAL_LANG_FORM_HELP_EXTENDED",  <<<END
        <tr>
    	  <td align="left" valign="top" nowrap><b>Toistotyyppi</b></td>
  	  	<td colspan="2"></td>
  		</tr>
  		<tr>
    	  <td colspan="2" align="left" valign="top">
	    	<table width="100%" border="0" cellspacing="2">
              <tr>
                <td width="60" align="left" valign="top"><u>P&auml;iv&auml;</u></td>
                <td width="110" align="left" valign="top" class="frm_td_bydays">
                  <font color="#000000">Yksitt&auml;inen tapahtuma<br/><i>(oletus)</i></font>
                </td>
                <td align="left" valign="top" class="frm_td_bydays">
                  <font color="#000000">Valitse t&auml;m&auml; toistumattomille yksi- ja monip&auml;iv&auml;isille tapahtumille, joiden tulisi esiinty&auml; kalenterissa joka p&auml;iv&auml; aloitus- ja lopetusp&auml;iv&auml;m&auml;&auml;r&auml;n v&auml;liss&auml;.</font>
                </td>
              </tr>
              <tr>
                <td width="60" rowspan="3" align="left" valign="top"><u>Viikko</u></td>
                <td width="110" align="left" valign="top" class="frm_td_byweeks">
                  <font color="#000000">
                    Kerran viikossa
                  </font>
                </td>
                <td align="left" valign="top" class="frm_td_byweeks">
                  <font color="#000000">
                  T&auml;m&auml; asetus antaa sinun valita viikonp&auml;iv&auml;n, jolloin tapahtuma toistuu.
                  <table border="0" width="100%" height="100%"><tr><td><b>Päivän numero</b> (esim. joka 10. päivä)</td></tr><tr><td><b>Päivän nimi</b> (esim. joka maanantai)</td></tr></table>
                  </font>
                </td>
              </tr>
              <tr>
                <td width="110" align="left" valign="top" class="frm_td_byweeks">
                  <font color="#000000">
                    Monena päivänä viikossa
                  </font>
                </td>
                <td align="left" valign="top" class="frm_td_byweeks">
                  <font color="#000000">T&auml;m&auml; asetus antaa sinun valita mill&auml; viikonp&auml;ivill&auml; tapahtuma n&auml;kyy.</font>
                </td>
              </tr>
              <tr>
                <td width="110" align="left" valign="top" class="frm_td_byweeks">
                  <font color="#000000"><i>Kuukauden viikot<br>yll&auml; oleville 'Kerran viikossa' ja 'Monena p&auml;iv&auml;n&auml; viikossa' asetuksille</i></font></td>
                  <td align="left" valign="top" class="frm_td_byweeks">
                  <font color="#000000">
                  <table border="0" width="100%" height="100%">
                    <tr><td><b>Viikko 1 :</b> Kuukauden ensimm&auml;inen viikko</td></tr>
                    <tr><td><b>Viikko 2 :</b> Kuukauden toinen viikko</td></tr>
                    <tr><td><b>Viikko 3 :</b> Kuukauden kolmas viikko</td></tr>
                    <tr><td><b>Viikko 4 :</b> Kuukauden neljäs viikko</td></tr>
                    <tr><td><b>Viikko 5 :</b> Kuukauden viides viikko (jos kyseisess&auml; kuukaudessa on viisi viikkoa)</td></tr>
                   </table>
                 </font>
                </td>
              </tr>
              <tr>
                <td width="60" rowspan="2" align="left" valign="top"><u>Kuukausi</u></td>
                <td width="110" align="left" valign="top" class="frm_td_bymonth">
                  <font color="#000000">Kerran kuussa</font></td>
                <td align="left" valign="top" class="frm_td_bymonth">
                  <font color="#000000">
                     T&auml;m&auml; asetus antaa sinun valita viikonp&auml;iv&auml;n, jolloin tapahtuma toistuu.
                     <table border="0" width="100%" height="100%"><tr><td><b>Päivän numero</b> (esim. joka 10. päivä)</td></tr><tr><td><b>Päivän nimi</b> (esim. joka maanantai)</td></tr></table>

                  </font>
                </td>
              </tr>
              <tr>
                <td width="110" align="left" valign="top" class="frm_td_bymonth">
                  <font color="#000000">
                  Joka kuun lopussa
                  </font>
                </td>
                <td align="left" valign="top" class="frm_td_bymonth">
                  <font color="#000000">
				   Tapahtuma toistuu jokaisen kuukauden viimeisen&auml; p&auml;iv&auml;n&auml; riippumatta p&auml;iv&auml;n numerosta, jos kuun viimeinen p&auml;iv&auml;
		sijaitsee tapahtuman aloitus- ja lopetusp&auml;iv&auml;m&auml;&auml;r&auml;n v&auml;liss&auml;.
                  </font>
                </td>
              </tr>
              <tr>
                <td width="60" rowspan="2" align="left" valign="top"><u>Vuosi</u></td>
                <td width="110" align="left" valign="top" class="frm_td_byyear">
                  <font color="#000000">
                  Kerran vuodessa
                  </font>
                </td>
                <td align="left" valign="top" class="frm_td_byyear">
                  <font color="#000000">
                  T&auml;m&auml; asetus antaa sinun valita yhden p&auml;iv&auml;n, jolloin tapahtuma toistuu vuosittain.
                  <table border="0" width="100%" height="100%"><tr><td><b>Päivän numero</b> (esim. joka 10. päivä)</td></tr><tr><td><b>Päivän nimi</b> (esim. joka maanantai)</td></tr></table>
                  </font>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <!-- END REPEAT -->
END
);

// translate combatibility constants and remove include file
include_once(dirname(__FILE__).'/compat15.php');

// compatibility constants
DEFINE("_CAL_LANG_WARNTITLE",	_E_WARNTITLE);
DEFINE("_CAL_LANG_WARNCAT",		_E_WARNCAT);
DEFINE("_CAL_LANG_STATE",		_E_STATE);
DEFINE("_CAL_LANG_HITS",		_E_HITS);
DEFINE("_CAL_LANG_CREATED",		_E_CREATED);
DEFINE("_CAL_LANG_LAST_MOD",	_E_LAST_MOD);
DEFINE("_CAL_LANG_EDIT",		_E_EDIT);
DEFINE("_CAL_LANG_SEARCH_TITLE",_SEARCH_TITLE);
DEFINE("_CAL_LANG_PRINT",		_CMN_PRINT);

?>
