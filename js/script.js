function showContainer(containerId) {
    document.getElementById('inscription_container').classList.add('d-none');
    document.getElementById('connection_container').classList.add('d-none');

    document.getElementById(containerId).classList.remove('d-none');
}

function showContainerbis(containerId) {
    document.getElementById('rdv_container').classList.add('d-none');
    document.getElementById('liste_container').classList.add('d-none');

    document.getElementById(containerId).classList.remove('d-none');
}
