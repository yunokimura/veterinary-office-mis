<!-- Announcement Detail Modal -->
<div id="announcementModal" class="fixed inset-0 z-[1000] hidden overflow-y-auto" aria-labelledby="modalTitle" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center p-4 text-center">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeAnnouncementModal()"></div>
        
        <!-- Modal Panel -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all">
            <!-- Close Button -->
            <button type="button" onclick="closeAnnouncementModal()" 
                    class="absolute top-4 right-4 z-10 p-2 rounded-lg bg-white/80 backdrop-blur-sm hover:bg-white shadow-sm transition-colors border border-gray-200"
                    aria-label="Close modal">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <div id="modalContent">
                <!-- Dynamic content loaded via JS -->
            </div>
        </div>
    </div>
</div>

<script>
function openAnnouncementModal(id) {
    fetch('/announcements/' + id)
        .then(r => r.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('announcementModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
}

function closeAnnouncementModal() {
    document.getElementById('announcementModal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeAnnouncementModal();
});
</script>