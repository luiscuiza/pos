function toggleStatusSwitch(checkbox, activeText = 'Activo', inactiveText = 'Inactivo') {
    const statusLabel = checkbox.closest('.switch-container').querySelector('.status-label');
    if (checkbox.checked) {
        statusLabel.textContent = activeText;
        statusLabel.style.color = '#4caf50';
    } else {
        statusLabel.textContent = inactiveText;
        statusLabel.style.color = '#ccc';
    }
}
