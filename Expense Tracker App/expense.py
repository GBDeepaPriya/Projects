import pandas as pd 
 
# Load the expense data 
df = pd.read_csv('expenses.csv') 
# Preview first few records 
print("📌Data Preview:") 
print(df.head()) 

# Check structure 
print("\n📊Dataset Info:") 
print(df.info()) 

# Summary stats 
print("\n📈Summary Statistics:") 
print(df.describe()) 

# Check unique categories and types 
print("\n📋Unique Categories:", df['Category'].unique()) 
print("🧾Transaction Types:", df['Type'].unique())

# Step 1: View raw data 
print("🔍Preview:") 
print(df.head()) 

# Step 2: Remove duplicates (if any) 
df = df.drop_duplicates() 

# Step 3: Handle missing values 
print("\n❓ Missing Values:") 
print(df.isnull().sum()) 

# Drop rows where critical fields are missing 
df = df.dropna(subset=['Date', 'Amount', 'Category', 'Type']) 

# Step 4: Convert data types 
df['Date'] = pd.to_datetime(df['Date'], errors='coerce')  # Convert Date column 
df['Amount'] = pd.to_numeric(df['Amount'], errors='coerce')  # Ensure Amount is numeric 

# Step 5: Standardize categorical text (title case, no extra spaces) 
df['Category'] = df['Category'].astype(str).str.strip().str.title() 
df['Type'] = df['Type'].astype(str).str.strip().str.title() 

# Step 6: Create new features 
df['Month'] = df['Date'].dt.month_name() 
df['Day'] = df['Date'].dt.day 
df['Weekday'] = df['Date'].dt.day_name() 

# Step 7: Preview final cleaned data 
print("\n✅ Cleaned Data Sample:") 
print(df.head()) 

# Save to new file for analysis/visualization 
df.to_csv("cleaned_expenses.csv", index=False) 
print("💾Cleaned data saved as 'cleaned_expenses.csv'") 

# EDA & Visualization 
import pandas as pd 
import matplotlib.pyplot as plt 
import seaborn as sns 

# Load cleaned dataset 
df = pd.read_csv('cleaned_expenses.csv') 

# Set style 
sns.set(style="whitegrid") 

# --- 1. Bar Chart: Total Amount by Category --- 
category_sum = df.groupby('Category')['Amount'].sum().sort_values(ascending=False) 
plt.figure(figsize=(10,5)) 
sns.barplot(x=category_sum.index, y=category_sum.values, palette='Set2') 
plt.title("Total Expense by Category") 
plt.xlabel("Category") 
plt.ylabel("Total Spent (₹)") 
plt.xticks(rotation=45) 
plt.tight_layout() 
plt.show() 

# --- 2. Pie Chart: Expense Distribution --- 
expense_df = df[df['Type'] == 'Expense'] 
category_expense = expense_df.groupby('Category')['Amount'].sum() 
plt.figure(figsize=(7,7)) 
plt.pie(category_expense, labels=category_expense.index, autopct='%1.1f%%', 
startangle=140) 
plt.title("Expense Distribution by Category") 
plt.axis('equal') 
plt.tight_layout() 
plt.show() 

# --- 3. Line Plot: Monthly Expense Trend --- 
df['Month_Num'] = pd.to_datetime(df['Date']).dt.month 
monthly_expense = df[df['Type'] == 'Expense'].groupby('Month_Num')['Amount'].sum() 
monthly_income = df[df['Type'] == 'Income'].groupby('Month_Num')['Amount'].sum() 
plt.figure(figsize=(10,5)) 
monthly_expense.plot(label='Expense', marker='o') 
monthly_income.plot(label='Income', marker='o') 
plt.title("Monthly Income vs Expense") 
plt.xlabel("Month (1-12)") 
plt.ylabel("Amount (₹)") 
plt.legend() 
plt.grid(True) 
plt.tight_layout() 
plt.show() 

# --- 4. Count Plot: Transactions by Day of Week --- 
plt.figure(figsize=(8,4)) 
sns.countplot(x='Weekday', data=df, order=["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"], palette='coolwarm') 
plt.title("Transactions by Weekday") 
plt.xlabel("Weekday") 
plt.ylabel("Number of Transactions") 
plt.tight_layout() 
plt.show()
