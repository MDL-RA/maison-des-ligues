require('materialize-css');
M.AutoInit() ;
document.addEventListener('DOMContentLoaded', function() {
    const elems = document.querySelectorAll('select');
    const instances = M.FormSelect.init(elems, options);
});