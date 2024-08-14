function toggleStatusSwitch(checkbox) {
    const statusLabel = checkbox.closest('.switch-container').querySelector('.status-label');
    if (checkbox.checked) {
        statusLabel.textContent = 'Activo';
        statusLabel.style.color = '#4caf50';
    } else {
        statusLabel.textContent = 'Inactivo';
        statusLabel.style.color = '#ccc';
    }
}
