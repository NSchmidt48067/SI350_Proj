/**
 * Description: js functions that assist with verifying user input
 * Creation Date: 14NOV2025
 * Author: George Prielipp
 */

function any(lst, func) {
    let res = false;
    lst.forEach(element => {
        res = res || func(element);
    });
    return res;
}

function getInputValues(form) {
    let formData = new FormData(form);

    let inputs = [];
    for(const key of formData.keys()) {
        let input = formData.get(key);
        if(input.type == "application/octet-stream")
            inputs.push( input.name );
        else
            inputs.push( input );
    }

    return inputs;
}

function verify(form) {
    let vals = getInputValues(form);
    // make sure non are empty (could do more checks as well);
    return !any(vals, (e) => {console.log(e); return e == ""});
}