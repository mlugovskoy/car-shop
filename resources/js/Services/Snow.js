class Snow {
    constructor({
        count = 80,
        minSize = 2,
        maxSize = 12,
        minSpeed = 0.2,
        maxSpeed = 1.2,
        image
    } = {}) {
        this.count = count;
        this.minSize = minSize;
        this.maxSize = maxSize;
        this.minSpeed = minSpeed;
        this.maxSpeed = maxSpeed;
        this.image = image;
        this.flakes = [];
        this.lastTime = 0;
        this.isRunning = false;
    }

    init() {
        if (this.isRunning) return;
        this.isRunning = true;

        this.ensureStyles();

        for (let i = 0; i < this.count; i++) {
            this.createFlake();
        }

        this.animateFlake(performance.now());
    }

    createFlake() {
        const size = Math.floor(Math.random() * (this.maxSize - this.minSize) + this.minSize);
        const speed = this.minSpeed + (1 - (size - this.minSize) / (this.maxSize - this.minSize)) * (this.maxSpeed - this.minSpeed);
        const swayAmount = this.minSize + size * this.maxSpeed;
        const swaySpeed = this.minSpeed + Math.random() * this.maxSpeed;
        const startX = Math.floor(Math.random() * window.innerWidth);
        const startY = Math.floor(Math.random() * (window.innerHeight + 100) - 100);

        const el = document.createElement('div');
        el.classList.add('snow-widget');
        el.style.width = `${size}px`;
        el.style.height = `${size}px`;
        el.style.backgroundImage = `url(${this.image})`;
        el.style.opacity = 0.4 + (size / this.maxSize) * 0.6;
        document.body.appendChild(el);

        this.flakes.push({
            el, size, speed, startX, swayAmount, swaySpeed, y: startY, lifetime: Math.random() * 10000
        });
    }

    ensureStyles() {
        if (document.getElementById('snow-styles')) return;

        const style = document.createElement('style');
        style.id = 'snow-styles';
        style.textContent = `
        .snow-widget {
            position: fixed;
            background-size: cover;
            top: 0;
            left: 0;
            z-index: 9999;
            pointer-events: none;
        }`;
        document.head.appendChild(style);
    }

    animateFlake(time) {
        const deltaTime = time - this.lastTime;
        this.lastTime = time;

        const viewHeight = window.innerHeight;
        const viewWidth = window.innerWidth;

        for (const flake of this.flakes) {
            flake.y += flake.speed * (deltaTime / 16);

            if (flake.y > viewHeight + flake.size) {
                flake.y = -flake.size;
                flake.startX = Math.random() * viewWidth;
            }

            const swayOffset = Math.sin((time + flake.lifetime) * 0.001 * flake.swaySpeed) * flake.swayAmount;
            const x = flake.startX + swayOffset;

            flake.el.style.transform = `translate(${x}px, ${flake.y}px)`;
        }

        if (this.isRunning) {
            requestAnimationFrame((t) => this.animateFlake(t));
        }
    }

    destroy() {
        this.isRunning = false;
        this.flakes.forEach(f => f.el?.remove());
        this.flakes = [];
    }
}

export default Snow
