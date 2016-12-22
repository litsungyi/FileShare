/*******************************************************************************

  Name:           No IE Information Bar
  Version:        0.2.8
  Date:           December 15, 2004
  Author:         Martin Ng        <http://minghong.webhop.org>
  Contributors:   Ching Yonghan
  Translators:    asteko           [Turkish]
                  Benobi           [Spanish]
                  bogus            [Polish]
                  Ching Yonghan    [Chinese/English/Malay]
                  Dasch            [Danish]
                  dariosc          [Italian]
                  Freya            [Italian]
                  Grauw            [Dutch]
                  indicavia        [Norwegian]
                  jcg              [French]
                  Lim Chee Aun     [English]
                  Marko Burjek     [Slovenian]
                  Needle           [Japan]
                  naylor83         [Swedish]
                  ricki            [German]
                  rjamorim         [Brazilian Portuguese]
                  sergei plaxienko [Russian]
                  Troels Nybo      [Danish]
                  Up North         [Dutch]
                  villep           [Finnish]
                  warhaven         [Dutch]
                  yuku             [Indonesian]
                  ZZZJR            [Czech]

  ------------------------------------------------------------------------------

  Creative Commons Deed
  Attribution-NonCommercial 2.0

  You are free:
  * to copy, distribute, display, and perform the work
  * to make derivative works

  Under the following conditions:
  * Attribution.
    You must give the original author credit.
  * Noncommercial.
    You may not use this work for commercial purposes.
  * For any reuse or distribution, you must make clear to others the license
    terms of this work.
  * Any of these conditions can be waived if you get permission from the
    copyright holder.

  Your fair use and other rights are in no way affected by the above.

  Read full license here:
  http://creativecommons.org/licenses/by-nc/2.0/legalcode

*******************************************************************************/

var tid;

/**
 * No IE Information Bar
 * @author Martin Ng <http://minghong.webhop.org>
 * @author kaneter
 * @version 0.2.6
 * @since 0.1
 *
 * @param id The ID of the infobar
 * @param url the URL that the infobar links to
 * @param tooltip The tooltip string
 * @param message The message string
 * @param animated Turn animatation on/off
 */
function InfoBar( id, url, tooltip, message, animated )
{
    // Initialize the infobar
    var infobar = document.getElementById( id );
    for ( var i = 0; i < infobar.children.length; i++ )
    {
        infobar.removeChild( infobar.children[i] );
    }

    // Update the infobar and viewplot
    var textNode = document.createTextNode( message );
    var linkNode = document.createElement( "a" );
    linkNode.href = url;
    linkNode.title = tooltip;
    linkNode.appendChild( textNode );
    infobar.appendChild( linkNode );

    // Move the infobar and viewplot
    if ( animated )
    {
        var inHeight = infobar.offsetHeight;
        var viHeight = viewplot.offsetHeight;
        infobar.runtimeStyle.position = "absolute";
        infobar.runtimeStyle.top = inHeight * -1;
        infobar.runtimeStyle.left = 0;
        viewplot.runtimeStyle.position = "absolute";
        viewplot.runtimeStyle.top = 0;
        viewplot.runtimeStyle.left = 0;
        viewplot.runtimeStyle.height = viHeight + inHeight;
        tid = setInterval( "lowerInfoBar( infobar, viewplot )", 1 );
    }
}

/**
 * Lower the infobar
 * @author Martin Ng <http://minghong.webhop.org>
 * @author kaneter
 * @version 0.2
 * @since 0.2
 *
 * @param infobar The infobar object
 * @param viewplot The viewplot object
 */
function lowerInfoBar( infobar, viewplot )
{
    if ( parseInt( infobar.currentStyle.top ) < 0 )
    {
        infobar.runtimeStyle.top = parseInt( infobar.currentStyle.top ) + 1;
        viewplot.runtimeStyle.top = parseInt( viewplot.runtimeStyle.top ) + 1;
        viewplot.runtimeStyle.height = parseInt( viewplot.runtimeStyle.height ) - 1;
    }
    else
    {
        clearInterval( tid );
    }
}

/**
 * Create Infobar
 * @author Martin Ng <http://minghong.webhop.org>
 * @version 0.2.8
 * @since 0.1
 */
window.onload = function()
{
    // Detect the locale
    var locale = navigator.userLanguage;
    switch ( locale )
    {

    // Traditional Chinese
    case "zh-tw":
    case "zh-hk":
    case "zh-mo":
        locale = "zh-tw";
        break;
    // For others, remove country code
    default:
        if ( locale.indexOf("-") > 0 )
        {
            locale = locale.substring( 0, locale.indexOf("-") );
        }
    }

    // Create localized tooltips
    var tooltips = new Array();
    tooltips["zh-tw"] = "Mozilla Taiwan - Ready to use Firefox";

    // Create localized messages
    var messages = new Array();
    messages["zh-tw"] = "Sorry, this website doesn't suggest you to use Internet Explorer. Please use the browser which conforms W3C standard. Such as Mozilla Firefox or Opera. - Li Tsung-Yi";

    // Select localized strings
    var tooltip = tooltips[locale] ? tooltips[locale] : tooltips["en"];
    var message = messages[locale] ? messages[locale] : messages["en"];

    // Create infobar
    var infobar = new InfoBar(
        "infobar", "http://moztw.org/", tooltip, message, true );
}
