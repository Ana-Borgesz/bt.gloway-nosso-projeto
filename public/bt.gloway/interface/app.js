class GlowayApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupNavigation();
        this.setupScrollEffects();
        this.setupAnimations();
        this.createParticles();
        this.setupBrilhoInterativo();
    }

    setupNavigation() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        
        document.querySelectorAll('nav a').forEach(link => {
            const linkPage = link.getAttribute('href');
            if (linkPage === currentPage) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });

        document.getElementById('verProfissoesBtn').addEventListener('click', (e) => {
            e.preventDefault();
            this.showMessage('Sistema de profissões em desenvolvimento!', 'info');
        });

        document.getElementById('profissoesLink').addEventListener('click', (e) => {
            e.preventDefault();
            this.showMessage('Explore as profissões após realizar o teste de aptidão!', 'info');
        });
    }

    setupScrollEffects() {
        const header = document.getElementById('mainHeader');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 30) {
                header.style.background = 'rgba(255, 255, 255, 0.12)';
                header.style.backdropFilter = 'blur(20px)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.08)';
                header.style.backdropFilter = 'blur(15px)';
            }
        });
    }

    setupAnimations() {
        this.enhanceButtons();
        this.enhanceNavigation();
    }

    enhanceButtons() {
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', function(e) {
                this.style.transform = 'translateY(-3px) scale(1.02)';
            });
            
            btn.addEventListener('mouseleave', function(e) {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }

    enhanceNavigation() {
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('mouseenter', function(e) {
                this.style.transform = 'translateY(-2px)';
            });
            
            link.addEventListener('mouseleave', function(e) {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    createParticles() {
        const particlesContainer = document.getElementById('particulas');
        const particleCount = 15;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particula';
            
            const size = Math.random() * 6 + 2;
            const left = Math.random() * 100;
            const animationDuration = Math.random() * 20 + 20;
            const animationDelay = Math.random() * -30;
            
            particle.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${left}%;
                top: ${Math.random() * 100}%;
                animation-duration: ${animationDuration}s;
                animation-delay: ${animationDelay}s;
                background: rgba(255, 255, 255, ${Math.random() * 0.3 + 0.1});
            `;
            
            particlesContainer.appendChild(particle);
        }
    }

    setupBrilhoInterativo() {
        document.addEventListener('mousemove', (e) => {
            const brilho = document.querySelector('.brilho-interativo');
            brilho.style.left = e.clientX + 'px';
            brilho.style.top = e.clientY + 'px';
        });
    }

    showMessage(message, type = 'info') {
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = `
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%) translateY(-20px);
            padding: 15px 25px;
            background: ${type === 'info' ? '#ff4353' : '#e63946'};
            color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            z-index: 10000;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 14px;
            opacity: 0;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        `;
        
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);

        setTimeout(() => {
            messageDiv.style.opacity = '1';
            messageDiv.style.transform = 'translateX(-50%) translateY(0)';
        }, 100);

        setTimeout(() => {
            messageDiv.style.opacity = '0';
            messageDiv.style.transform = 'translateX(-50%) translateY(-20px)';
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.parentNode.removeChild(messageDiv);
                }
            }, 300);
        }, 2500);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new GlowayApp();
});