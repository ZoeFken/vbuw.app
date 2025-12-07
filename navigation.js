(function buildNavigation() {
  const THEME_KEY = 'vbuw-theme';
  const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  const storedTheme = localStorage.getItem(THEME_KEY);
  const initialTheme = storedTheme || (prefersDark ? 'dark' : 'light');
  const toggleInputs = [];

  const applyTheme = (mode) => {
    const root = document.documentElement;
    root.classList.toggle('theme-dark', mode === 'dark');
    root.dataset.theme = mode;
  };

  const syncThemeToggles = (checked, source) => {
    toggleInputs.forEach((input) => {
      if (input !== source) input.checked = checked;
    });
  };

  const handleThemeChange = (input) => {
    const mode = input.checked ? 'dark' : 'light';
    localStorage.setItem(THEME_KEY, mode);
    applyTheme(mode);
    syncThemeToggles(input.checked, input);
  };

  const createThemeToggle = (opts = {}) => {
    const toggleLabel = document.createElement('label');
    toggleLabel.className = `theme-toggle${opts.className ? ` ${opts.className}` : ''}`;
    const toggleInput = document.createElement('input');
    toggleInput.type = 'checkbox';
    toggleInput.ariaLabel = 'Schakel dark mode';
    toggleInput.checked = initialTheme === 'dark';
    const toggleVisual = document.createElement('span');
    toggleVisual.className = 'toggle';
    const toggleText = document.createElement('span');
    toggleText.className = 'theme-toggle__text';
    toggleText.textContent = 'Dark mode';
    toggleLabel.append(toggleInput, toggleVisual, toggleText);
    toggleInputs.push(toggleInput);
    toggleInput.addEventListener('change', () => handleThemeChange(toggleInput));
    return toggleLabel;
  };

  applyTheme(initialTheme);

  const placeholder = document.querySelector('[data-nav-placeholder]');
  if (!placeholder) return;

  const current = (document.body && document.body.dataset.documentType) || '';
  const links = [
    { id: 's627', href: 's627.html', label: 'S627' },
    { id: 's460', href: 's460.html', label: 'S460' },
    { id: 'drive', href: 'https://drive.google.com/drive/folders/1wfK-iDhOTg_Xtzm-rLQYlmB-5gyzOYTZ?usp=drive_link', label: 'Google Drive', external: true },
    { id: 'locaties', href: 'https://zoefken.github.io/vbuw-locations/', label: 'locaties', external: true },
  ];

  const nav = document.createElement('nav');
  nav.className = 'topnav';

  const navInner = document.createElement('div');
  navInner.className = 'nav-inner';

  const brand = document.createElement('a');
  brand.className = 'brand';
  brand.href = 'index.html';
  brand.textContent = 'VBUW docs';

  const navLinks = document.createElement('div');
  navLinks.className = 'nav-links';

  const buildLinks = (container) => links.forEach((item) => {
    const link = document.createElement('a');
    link.href = item.href;
    link.textContent = item.label;
    if (item.external) {
      link.target = '_blank';
      link.rel = 'noreferrer noopener';
    }
    if (item.id && item.id === current) link.classList.add('active');
    container.appendChild(link);
  });
  buildLinks(navLinks);

  const navActions = document.createElement('div');
  navActions.className = 'nav-actions';

  const desktopToggle = createThemeToggle();
  navActions.append(navLinks, desktopToggle);
  navInner.append(brand, navActions);
  nav.append(navInner);
  placeholder.replaceWith(nav);

  // Mobile sticky bar + hamburger menu
  const mobileBar = document.createElement('div');
  mobileBar.className = 'mobile-nav-bar';
  const mobileToggle = createThemeToggle({ className: 'theme-toggle--mobile' });
  const menuButton = document.createElement('button');
  menuButton.type = 'button';
  menuButton.className = 'nav-hamburger';
  menuButton.ariaLabel = 'Open menu';
  menuButton.setAttribute('aria-expanded', 'false');
  menuButton.innerHTML = '<span></span><span></span><span></span>';
  mobileBar.append(mobileToggle, menuButton);
  document.body.appendChild(mobileBar);

  const mobileMenu = document.createElement('div');
  mobileMenu.className = 'mobile-menu';
  const mobileMenuPanel = document.createElement('div');
  mobileMenuPanel.className = 'mobile-menu__panel';
  const mobileBrand = brand.cloneNode(true);
  const mobileLinks = document.createElement('div');
  mobileLinks.className = 'mobile-menu__links';
  buildLinks(mobileLinks);
  mobileMenuPanel.append(mobileBrand, mobileLinks);
  mobileMenu.append(mobileMenuPanel);
  document.body.appendChild(mobileMenu);

  const setMenuOpen = (isOpen) => {
    mobileMenu.classList.toggle('open', isOpen);
    document.body.classList.toggle('mobile-menu-open', isOpen);
    menuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  };

  menuButton.addEventListener('click', () => {
    const willOpen = !mobileMenu.classList.contains('open');
    setMenuOpen(willOpen);
  });

  mobileMenu.addEventListener('click', (evt) => {
    if (evt.target === mobileMenu) setMenuOpen(false);
  });

  mobileMenu.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setMenuOpen(false));
  });
})();
