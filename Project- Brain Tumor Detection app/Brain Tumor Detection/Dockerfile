FROM python:3.9

# Set working directory
WORKDIR /app

# Copy everything
COPY . .

# Install Python dependencies
RUN pip install --no-cache-dir -r requirements.txt

# Expose port (Hugging Face uses 7860)
EXPOSE 7860

# Run the app
CMD ["python", "app.py"]
