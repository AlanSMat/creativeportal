//** function used to toggle requested assets under "3.Asset Specifics", its called by a click event on a div.                
var divSourceSwap = function () {

    //** find the tick image under the asset that's been clicked on. 
    var $img = $(this).find('img');
    //alert($img.attrib('id'));
    //** toggle on or off
    $('#' + $(this).attr('id') + '_container').toggle();

    //** set variable of the attribute 'alt-src'
    var divNewSource = $img.data('alt-src');

    //** set the toggle value of the attribute 'alt-src'
    $img.data('alt-src', $img.attr('src'));

    //** set the toggle value of the attribute 'src'
    $img.attr('src', divNewSource);

    //** set a variable to access the properties of the hidden fields written out when the page as loaded
    var hidden_field = '#' + $(this).attr('id') + '_hidden';

    //** set the value of the a hidden field ( 0 or 1), this will be used when the form is posted to tell if the option has been selected
    $(hidden_field).attr('value') == 0 ? $(hidden_field).val('1') : $(hidden_field).val('0');

}
