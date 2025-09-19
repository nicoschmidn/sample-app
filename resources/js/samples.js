document.addEventListener('DOMContentLoaded', () => {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file');
    const submitBtn = document.getElementById('submit-btn');
    const removeBtn = document.getElementById('remove-btn');
    const fileNameSpan = document.getElementById('file-name');

    if (!dropArea || !fileInput) return;

    const preventDefaults = e => {
        e.preventDefault();
        e.stopPropagation();
    };

    ['dragenter','dragover','dragleave','drop'].forEach(event =>
        dropArea.addEventListener(event, preventDefaults)
    );

    ['dragenter','dragover'].forEach(event =>
        dropArea.addEventListener(event, () => dropArea.classList.add('highlight'))
    );

    ['dragleave','drop'].forEach(event =>
        dropArea.addEventListener(event, () => dropArea.classList.remove('highlight'))
    );

    dropArea.addEventListener('drop', e => handleFiles(e.dataTransfer.files));
    fileInput.addEventListener('change', e => handleFiles(e.target.files));
    removeBtn.addEventListener('click', resetFile);

    function handleFiles(files) {
        if (!files.length) return;
        fileInput.files = files;
        fileNameSpan.textContent = files[0].name;
        toggleFileUI(true);
    }

    function resetFile() {
        fileInput.value = '';
        toggleFileUI(false);
    }

    function toggleFileUI(hasFile) {
        fileNameSpan.style.display = hasFile ? 'block' : 'none';
        submitBtn.style.display = hasFile ? 'inline-block' : 'none';
        removeBtn.style.display = hasFile ? 'inline-block' : 'none';
    }
});
