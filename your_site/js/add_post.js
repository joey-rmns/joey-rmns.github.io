
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('add-post-form');
  const titleInput = document.getElementById('title');
  const dateInput = document.getElementById('date');
  const categoryInput = document.getElementById('category');
  const contentInput = document.getElementById('content');
  const saveDraftBtn = document.getElementById('save-draft-btn');
  const clearDraftBtn = document.getElementById('clear-draft-btn');
  const draftStatus = document.getElementById('draft-status');

  const DRAFT_KEY = 'fashion-blog-post-draft';

  loadDraft();

  if (saveDraftBtn) {
    saveDraftBtn.addEventListener('click', () => {
      saveDraft();
      showDraftStatus();
      alert('Draft saved successfully!');
    });
  }

  if (clearDraftBtn) {
    clearDraftBtn.addEventListener('click', () => {
      if (confirm('Are you sure you want to clear the saved draft?')) {
        clearDraft();
        titleInput.value = '';
        dateInput.value = dateInput.defaultValue; 
        categoryInput.value = '';
        contentInput.value = '';
        hideDraftStatus();
        alert('Draft cleared!');
      }
    });
  }

  form.addEventListener('submit', () => {
    clearDraft();
  });

]  function saveDraft() {
    const draft = {
      title: titleInput.value.trim(),
      date: dateInput.value.trim(),
      category: categoryInput.value.trim(),
      content: contentInput.value.trim(),
      timestamp: Date.now()
    };

    localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
  }

  function loadDraft() {
    const savedDraft = localStorage.getItem(DRAFT_KEY);
    
    if (!savedDraft) {
      return;
    }

    try {
      const draft = JSON.parse(savedDraft);
      
      // Only load if there's actual content
      if (draft.title || draft.category || draft.content) {
        titleInput.value = draft.title || '';
        dateInput.value = draft.date || dateInput.defaultValue;
        categoryInput.value = draft.category || '';
        contentInput.value = draft.content || '';
        
        showDraftStatus();
      }
    } catch (err) {
      console.error('Error loading draft:', err);
    }
  }

  function clearDraft() {
    localStorage.removeItem(DRAFT_KEY);
  }

  function showDraftStatus() {
    if (draftStatus) {
      draftStatus.style.display = 'flex';
    }
  }

  function hideDraftStatus() {
    if (draftStatus) {
      draftStatus.style.display = 'none';
    }
  }
});