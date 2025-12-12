

document.addEventListener('DOMContentLoaded', () => {
  const deleteButtons = document.querySelectorAll('[data-delete-post]');

  deleteButtons.forEach((btn) => {
    btn.addEventListener('click', () => {
      const postId = btn.getAttribute('data-delete-post');
      if (!postId) return;

      const confirmed = window.confirm(
        'Are you sure you want to delete this post?'
      );
      if (!confirmed) return;
	  
	  

      const article = document.querySelector(
        `article[data-post-id="${CSS.escape(postId)}"]`
      );
      if (article && article.parentNode) {
        article.parentNode.removeChild(article);
      }

      const asideItem = document.querySelector(
        `[data-aside-post-id="${CSS.escape(postId)}"]`
      );
      if (asideItem && asideItem.parentNode) {
        asideItem.parentNode.removeChild(asideItem);
      }
	  
      if (window.refreshPagination) {
        window.refreshPagination();
      }

      const formData = new FormData();
      formData.append('action', 'delete');
      formData.append('id', postId);

      fetch('blog_actions.php', {
        method: 'POST',
        body: formData
      })
        .then((response) => response.text())
        .then((text) => {
          if (text !== 'OK') {
            console.warn('Delete did not return OK:', text);
          }
        })
        .catch((err) => {
          console.error('Error deleting post:', err);
        });
    });
  });

	// Theme Toggle Functionality
	
	function initThemeToggle() {
	const body = document.body;
	const themeToggleBtn = document.getElementById('theme-toggle-btn');

	if (!themeToggleBtn) {
	console.warn('Theme toggle button not found');
	return;
	}

	const DARK_THEME_CLASS = 'dark-theme';
	const STORAGE_KEY = 'fashion-blog-theme';

	const savedTheme = localStorage.getItem(STORAGE_KEY);

	if (savedTheme === DARK_THEME_CLASS) {
	body.classList.add(DARK_THEME_CLASS);
	}
	updateButtonIcon(body.classList.contains(DARK_THEME_CLASS));


	themeToggleBtn.addEventListener('click', () => {
	body.classList.toggle(DARK_THEME_CLASS);

	if (body.classList.contains(DARK_THEME_CLASS)) {
	  localStorage.setItem(STORAGE_KEY, DARK_THEME_CLASS);
	} else {
	  localStorage.removeItem(STORAGE_KEY);
	}

	updateButtonIcon(body.classList.contains(DARK_THEME_CLASS));
	});

	function updateButtonIcon(isDarkThemeActive) {
	if (isDarkThemeActive) {
	  themeToggleBtn.textContent = '☀️';
	  themeToggleBtn.title = 'Switch to light theme';
	} else {
	  themeToggleBtn.textContent = '🌙';
	  themeToggleBtn.title = 'Switch to dark theme';
	}
	}
	}
	initThemeToggle();
	
	//Comment Functionality 
	
  (function initComments() {
    loadAllComments();

    const commentForms = document.querySelectorAll('.comment-form');
    commentForms.forEach((form) => {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const postId = form.getAttribute('data-post-id');
        const authorInput = form.querySelector('input[name="author"]');
        const textInput = form.querySelector('textarea[name="text"]');
        
        const author = authorInput.value.trim() || 'Anonymous';
        const text = textInput.value.trim();
        
        if (!text) {
          alert('Please enter a comment.');
          return;
        }
        
        const formData = new FormData();
        formData.append('action', 'add_comment');
        formData.append('post_id', postId);
        formData.append('author', author);
        formData.append('text', text);
        
        fetch('comment_actions.php', {
          method: 'POST',
          body: formData
        })
          .then((response) => response.text())
          .then((responseText) => {
            if (responseText.startsWith('ERROR')) {
              alert('Failed to post comment: ' + responseText);
              return;
            }
            
            const newComment = JSON.parse(responseText);
            
            addCommentToPage(postId, newComment);
            
            authorInput.value = '';
            textInput.value = '';
            
            alert('Comment posted successfully!');
          })
          .catch((err) => {
            console.error('Error posting comment:', err);
            alert('Failed to post comment. Please try again.');
          });
      });
    });

    function loadAllComments() {
      fetch('comments.json')
        .then((response) => response.json())
        .then((comments) => {
          const commentsByPost = {};
          comments.forEach((comment) => {
            if (!commentsByPost[comment.post_id]) {
              commentsByPost[comment.post_id] = [];
            }
            commentsByPost[comment.post_id].push(comment);
          });
          
          Object.keys(commentsByPost).forEach((postId) => {
            const container = document.getElementById('comments-' + postId);
            if (container) {
              container.innerHTML = '';
              commentsByPost[postId].forEach((comment) => {
                addCommentToPage(postId, comment);
              });
            }
          });
          
          document.querySelectorAll('.comments-list').forEach((list) => {
            if (list.children.length === 0 || 
                (list.children.length === 1 && list.querySelector('.loading-comments'))) {
              list.innerHTML = '<p class="no-comments">No comments yet. Be the first to comment!</p>';
            }
          });
        })
        .catch((err) => {
          console.error('Error loading comments:', err);
          document.querySelectorAll('.comments-list').forEach((list) => {
            list.innerHTML = '<p class="no-comments">Unable to load comments.</p>';
          });
        });
    }

    function addCommentToPage(postId, comment) {
      const container = document.getElementById('comments-' + postId);
      if (!container) return;
      
      const noCommentsMsg = container.querySelector('.no-comments, .loading-comments');
      if (noCommentsMsg) {
        noCommentsMsg.remove();
      }
      
      const commentDiv = document.createElement('div');
      commentDiv.className = 'comment-item';
      commentDiv.innerHTML = `
        <div class="comment-header">
          <span class="comment-author">${escapeHtml(comment.author)}</span>
          <span class="comment-date">${escapeHtml(comment.date)}</span>
        </div>
        <div class="comment-text">${escapeHtml(comment.text)}</div>
      `;
      
      container.appendChild(commentDiv);
    }

    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }
  })();
  
  (function initPagination() {
    const blogMain = document.getElementById('blog-main');
    const postsPerPageSelect = document.getElementById('posts-per-page');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const prevPageBtnBottom = document.getElementById('prev-page-bottom');
    const nextPageBtnBottom = document.getElementById('next-page-bottom');
    const pageInfo = document.getElementById('page-info');
    const pageInfoBottom = document.getElementById('page-info-bottom');
    const asidePostList = document.getElementById('aside-post-list');

    if (!blogMain || !postsPerPageSelect) return;

    let currentPage = 1;
    let itemsPerPage = 5;
    let allPosts = [];
    let filteredPosts = []; 

    collectAllPosts();
    updatePagination();

    postsPerPageSelect.addEventListener('change', () => {
      const value = postsPerPageSelect.value;
      itemsPerPage = value === 'all' ? filteredPosts.length : parseInt(value);
      currentPage = 1;
      updatePagination();
    });

    prevPageBtn.addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        updatePagination();
        scrollToTop();
      }
    });

    prevPageBtnBottom.addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        updatePagination();
        scrollToTop();
      }
    });

    nextPageBtn.addEventListener('click', () => {
      const totalPages = Math.ceil(filteredPosts.length / itemsPerPage);
      if (currentPage < totalPages) {
        currentPage++;
        updatePagination();
        scrollToTop();
      }
    });

    nextPageBtnBottom.addEventListener('click', () => {
      const totalPages = Math.ceil(filteredPosts.length / itemsPerPage);
      if (currentPage < totalPages) {
        currentPage++;
        updatePagination();
        scrollToTop();
      }
    });

    function collectAllPosts() {
      allPosts = Array.from(blogMain.querySelectorAll('.blog-post'));
      filteredPosts = [...allPosts];
    }

    function updatePagination() {
      if (filteredPosts.length === 0) {
        prevPageBtn.disabled = true;
        nextPageBtn.disabled = true;
        prevPageBtnBottom.disabled = true;
        nextPageBtnBottom.disabled = true;
        pageInfo.textContent = 'No posts';
        pageInfoBottom.textContent = 'No posts';
        return;
      }

      const totalPages = Math.ceil(filteredPosts.length / itemsPerPage);
      
      if (currentPage > totalPages) {
        currentPage = totalPages;
      }
      if (currentPage < 1) {
        currentPage = 1;
      }

      const start = (currentPage - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const postsToShow = filteredPosts.slice(start, end);

      allPosts.forEach(post => {
        post.style.display = 'none';
      });

      postsToShow.forEach(post => {
        post.style.display = 'block';
      });

      updateAsideList(postsToShow);

]      const pageText = postsPerPageSelect.value === 'all' 
        ? `All ${filteredPosts.length} posts`
        : `Page ${currentPage} of ${totalPages}`;
      
      pageInfo.textContent = pageText;
      pageInfoBottom.textContent = pageText;

      prevPageBtn.disabled = currentPage === 1;
      prevPageBtnBottom.disabled = currentPage === 1;
      nextPageBtn.disabled = currentPage === totalPages || postsPerPageSelect.value === 'all';
      nextPageBtnBottom.disabled = currentPage === totalPages || postsPerPageSelect.value === 'all';
    }

    function updateAsideList(visiblePosts) {
      if (!asidePostList) return;

      const allAsideItems = Array.from(asidePostList.querySelectorAll('.blog-post-list-item'));
      
      const visiblePostIds = visiblePosts.map(post => post.getAttribute('data-post-id'));

      allAsideItems.forEach(item => {
        const postId = item.getAttribute('data-aside-post-id');
        if (visiblePostIds.includes(postId)) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    }

    function scrollToTop() {
      const blogPage = document.querySelector('.blog-page');
      if (blogPage) {
        blogPage.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }

    window.updatePaginationAfterSearch = function(searchFilteredPosts) {
      if (searchFilteredPosts) {
        filteredPosts = searchFilteredPosts;
      } else {
        filteredPosts = [...allPosts];
      }
      currentPage = 1;
      updatePagination();
    };

    window.refreshPagination = function() {
      collectAllPosts();
      currentPage = 1;
      updatePagination();
    };
  })();
  
  // Search Functionality 
  
  (function initSearch() {
    const searchInput = document.getElementById('post-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const searchInfo = document.getElementById('search-results-info');
    
    if (!searchInput) return;

    const allPosts = document.querySelectorAll('.blog-post');

    searchInput.addEventListener('input', () => {
      const keyword = searchInput.value.trim().toLowerCase();
      
      if (keyword === '') {
        clearSearchBtn.style.display = 'none';
        searchInfo.style.display = 'none';
		
		if(window.updatePaginationAfterSearch){
			window.updatePaginationAfterSearch(null);
			}
        return;
      }

      clearSearchBtn.style.display = 'inline-block';

      const matchedPosts = [];
      
      allPosts.forEach((post) => {
        const title = post.querySelector('.blog-post-title')?.textContent || '';
        const bodyText = post.querySelector('.blog-post-body')?.textContent || '';
        
        const titleMatch = title.toLowerCase().includes(keyword);
        const bodyMatch = bodyText.toLowerCase().includes(keyword);
        
        if (titleMatch || bodyMatch) {
          matchedPosts.push(post);
		}
	  });
          
      if (window.updatePaginationAfterSearch) {
        window.updatePaginationAfterSearch(matchedPosts);
      }

      searchInfo.style.display = 'block';
      if (matchedPosts.length === 0) {
        searchInfo.textContent = 'No posts found';
        searchInfo.className = 'search-info no-results';
      } else {
        searchInfo.textContent = `Found ${matchedPosts.length} post${matchedPosts.length === 1 ? '' : 's'}`;
        searchInfo.className = 'search-info has-results';
      }
    });

    if (clearSearchBtn) {
      clearSearchBtn.addEventListener('click', () => {
        searchInput.value = '';
        clearSearchBtn.style.display = 'none';
        searchInfo.style.display = 'none';

	if (window.updatePaginationAfterSearch) {
          window.updatePaginationAfterSearch(null);
        }
        
        searchInput.focus();
      });
    }
  })();
});