// Este JavaScript controla alguns efeitos da interface, como abrir painéis e mostrar/esconder formulários.
document.addEventListener('DOMContentLoaded', () => {
  const panelButtons = document.querySelectorAll('.toggle-panel');
  const formButtons = document.querySelectorAll('.toggle-form');

  panelButtons.forEach((button) => {
    const target = button.dataset.panel;
    button.addEventListener('click', (event) => {
      event.stopPropagation();
      document.querySelectorAll('.panel-dropdown').forEach((panel) => {
        panel.hidden = !panel.classList.contains(`panel-${target}`) ? true : !panel.hidden;
      });
      if (button.dataset.markRead === '1') {
        const params = new URLSearchParams(window.location.search);
        params.set('mark_notifications_read', '1');
        params.set('page', params.get('page') || 'dashboard');
        fetch(window.location.pathname + '?' + params.toString(), {
          method: 'GET',
          headers: { 'Accept': 'application/json' },
        }).then(() => {
          const badge = button.querySelector('.badge-count');
          if (badge) {
            badge.remove();
          }
          document.querySelectorAll('.panel-notifications .panel-item').forEach((item) => item.remove());
          const panel = document.querySelector('.panel-notifications');
          if (panel) {
            const empty = document.createElement('div');
            empty.className = 'panel-empty';
            empty.textContent = 'Nenhuma notificação nova.';
            panel.appendChild(empty);
          }
        }).catch(() => {
          
        });
      }
    });
  });

  formButtons.forEach((button) => {
    const target = button.dataset.panel;
    button.addEventListener('click', () => {
      const panel = document.getElementById(target);
      if (panel) {
        panel.classList.toggle('hidden');
      }
    });
  });

  document.addEventListener('click', (event) => {
    if (!event.target.closest('.panel-dropdown') && !event.target.closest('.toggle-panel')) {
      document.querySelectorAll('.panel-dropdown').forEach((panel) => panel.hidden = true);
    }
  });
});
