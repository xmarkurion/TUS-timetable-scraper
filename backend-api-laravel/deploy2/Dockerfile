FROM debian:bookworm

# Set environment variables for Playwright
ENV PLAYWRIGHT_BROWSERS_PATH=/ms-playwright

# Update and install required dependencies
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    gnupg \
    ca-certificates \
    libnss3 \
    libatk1.0-0 \
    libatk-bridge2.0-0 \
    libcups2 \
    libxcomposite1 \
    libxrandr2 \
    libxdamage1 \
    libxkbcommon0 \
    libgbm1 \
    libasound2 \
    libpangocairo-1.0-0 \
    libpango-1.0-0 \
    libgtk-3-0 \
    libxshmfence1 \
    libx11-xcb1 \
    libxcb-dri3-0 \
    libdrm2 \
    && apt-get clean

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    apt-get clean

# Install Playwright and its browsers
RUN npm install -g playwright && \
    npx playwright install-deps

WORKDIR /home/test
RUN npm init playwright@latest -y

# Install Playwright browsers (Chromium, Firefox, WebKit)
RUN npx playwright install --with-deps


# Default command to keep the container running
CMD ["tail", "-f", "/dev/null"]
