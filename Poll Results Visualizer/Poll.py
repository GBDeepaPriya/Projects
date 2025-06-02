import pandas as pd 

# Load dataset 
df = pd.read_csv("poll_data.csv") 

# Show the first few rows 
print("🔍Preview:") 
print(df.head()) 

# Data types and non-null values 
print("\n📊Dataset Info:") 
print(df.info()) 

# Basic statistics for numeric columns 
print("\n📈 Descriptive Stats:")
print(df.describe()) 

# Checking for missing values 
print("\n❓Missing Values:") 
print(df.isnull().sum()) 

# Checking unique responses for categorical fields 
print("\n 🧾 Unique Poll Options:") 
print("Preferred Tool:", df['Preferred Tool'].unique()) 
print("Satisfaction Ratings:", df['Satisfaction (1-5)'].unique()) 

# Drop rows where critical columns are missing (e.g., satisfaction or feedback) 
df = df.dropna(subset=['Preferred Tool', 'Satisfaction (1-5)'])

# Strip extra spaces and unify case for consistency 
df['Preferred Tool'] = df['Preferred Tool'] 

# Confirm unique values after cleanup 
print(df['Preferred Tool'].unique()) 

# Ensure Satisfaction is numeric 
df['Satisfaction (1-5)'] = pd.to_numeric(df['Satisfaction (1-5)'], errors='coerce') 

# Ensure Timestamp is a datetime object 
df['Timestamp'] = pd.to_datetime(df['Timestamp']) 

# Extract date from timestamp 
df['Date'] = df['Timestamp'].dt.date 
# Create feedback length column 
df['Feedback Length'] = df['Feedback'].astype(str).apply(len) 

df.to_csv("cleaned_poll_data.csv", index=False) 
print("✅Cleaned data saved to 'cleaned_poll_data.csv'") 

import matplotlib.pyplot as plt  
import seaborn as sns 
import sklearn
plt.figure(figsize=(8,5)) 
sns.countplot(x='Preferred Tool', data=df, palette='Set2') 
plt.title('Most Preferred Tools') 
plt.xlabel('Tool') 
plt.ylabel('Number of Votes') 
plt.xticks(rotation=30) 
plt.tight_layout() 
plt.show()

plt.figure(figsize=(6,4)) 
sns.histplot(df['Satisfaction (1-5)'], bins=5, kde=True, color='skyblue') 
plt.title('Satisfaction Rating Distribution') 
plt.xlabel('Rating') 
plt.ylabel('Frequency') 
plt.tight_layout() 
plt.show()

daily = df.groupby('Date').size() 
plt.figure(figsize=(8,4)) 
daily.plot(kind='line', marker='o') 
plt.title('Daily Poll Submissions') 
plt.xlabel('Date') 
plt.ylabel('Number of Responses') 
plt.grid(True) 
plt.tight_layout() 
plt.show()

plt.figure(figsize=(7,5)) 
sns.boxplot(x='Satisfaction (1-5)', y='Feedback Length', data=df, palette='coolwarm') 
plt.title('Feedback Length by Satisfaction Level') 
plt.tight_layout() 
plt.show() 

from wordcloud import WordCloud 
text = ' '.join(df['Feedback'].astype(str).tolist()) 
wordcloud = WordCloud(width=800, height=400, 
background_color='white', colormap='tab10').generate(text) 
plt.figure(figsize=(10,5)) 
plt.imshow(wordcloud, interpolation='bilinear') 
plt.axis('off') 
plt.title("Common Words in Feedback") 
plt.show()