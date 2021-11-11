/**
 * Includes the given script by creating a new \<script> tag in the html
 * and setting it's src= to the given script
 * 
 * @author ketrab2004
 * 
 * @param {String} script url to script to be included
 * @param {?Element} parent element to add the \<script> to [optional]
 * 
 * @returns {Element} the \<script> element that was created with the src set to script
 * 
 * @example
 * ```js
 *  includeScript("/js/example.js") // include script
        .addEventListener("load", function() // wait until loaded using an event listener
    {
        hello(); // call function from example.js when it's loaded
    }
 * ```
 */
function includeScript(script, parent)
{
    parent = parent ?? document.body; // if parent isn't set use <body>

    let element = document.createElement("script"); // create <script>

    element.src = script;
    element.type = "text/javascript";
    element.async = false; // set async to false, so that this gets loaded before the code continues
    element.defer = false;
    
    parent.insertBefore(element, parent.firstChild); // add <script> to top parent (probably <body>)

    return element;
}


/**
 * Includes the given scripts by creating new \<script> tags in the html
 * and setting their src='s to the given scripts using includeScript()
 * 
 * @author ketrab2004
 * 
 * @param {Array} scripts array of scripts to be included
 * @param {?Element} parent element to add the \<script>s to [optional]
 * 
 * @returns {Array} array of all the created script elements
 * 
 * @example
 * ```js
    includeMultipleScripts([ // include the scripts
        "/js/example.js", // has hello()
        "/js/a.js", // has a()
        "/js/b.js" // has b()
    ])
        [0].addEventListener("finished loading", function() // when finished loading (custom Event fired only on the first script)
    {
        hello(); a(); b(); // fire functions
    });
 * ```
 */
function includeMultipleScripts(scripts, parent)
{
    let loaded = 0;

    let scriptElements = [];

    const event = new Event("finished loading");

    scripts.forEach( function(script, index) {

        scriptElements.splice( index, 0,  // set slot in scriptElements array to script element
            includeScript(script, parent) // include script
        );

        scriptElements[index].addEventListener("load", function() // wait for loading
        {
            loaded++;

            if (loaded >= scripts.length) // if all scripts are loaded
            {
                scriptElements[0].dispatchEvent(event); // dispatch event on the first script (for an .addEventListener)
            }
        });

    });

    return scriptElements;
}
