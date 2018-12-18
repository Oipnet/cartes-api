document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});

    const dropdowns = document.querySelectorAll('.dropdown-trigger')

    for (var i = 0; i < dropdowns.length; i++){
        M.Dropdown.init(dropdowns[i], {
            inDuration: 300,
            outDuration: 225,
            constrain_width: false, // Does not change width of dropdown to that of the activator
            hover: true, // Activate on hover
            gutter: (document.querySelector('.dropdown-content').offsetWidth * 3) / 2.5 + 5, // Spacing from edge
            belowOrigin: false, // Displays dropdown below the button
            alignment: 'left'
        });
    }
});