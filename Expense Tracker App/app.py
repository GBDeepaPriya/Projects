import streamlit as st 
import pandas as pd 
import matplotlib.pyplot as plt 
import seaborn as sns 


# Title
st.title("🌡️ Expense Tracker")

# Upload CSV
uploaded_file = st.file_uploader("Upload your expense.csv file", type=['csv'])
if uploaded_file:
    df = pd.read_csv(uploaded_file)

    # Load dataset 
    df = pd.read_csv('cleaned_expenses.csv') 
    df['Date'] = pd.to_datetime(df['Date']) 
    df['Month'] = df['Date'].dt.month_name() 
    df['Weekday'] = df['Date'].dt.day_name() 

    # App Title 
    st.title("💰Expense Tracker Dashboard") 

    # Sidebar Filters 
    st.sidebar.header("🔍Filter Data") 
    category_filter = st.sidebar.multiselect("Select Categories", 
    options=df['Category'].unique(), default=list(df['Category'].unique())) 
    type_filter = st.sidebar.selectbox("Transaction Type", options=["All", "Expense", "Income"]) 

    # Filter DataFrame 
    filtered_df = df[df['Category'].isin(category_filter)] 
    if type_filter != "All": filtered_df = filtered_df[filtered_df['Type'] == type_filter] 

    # Show raw data checkbox 
    if st.checkbox("Show Raw Filtered Data"): 
       st.dataframe(filtered_df) 

    # Category-wise Total Chart 
    st.subheader("📊Total Amount by Category") 
    category_total = filtered_df.groupby('Category')['Amount'].sum().sort_values() 
    st.bar_chart(category_total) 

    # Monthly Trend Chart 
    st.subheader("📈 Monthly Trend") 
    monthly = filtered_df.groupby(df['Date'].dt.month)['Amount'].sum() 
    st.line_chart(monthly) 

    # Pie Chart for Expense Type 
    if type_filter == "Expense": 
       st.subheader("🍕Expense Distribution") 
       pie_data = filtered_df.groupby('Category')['Amount'].sum() 
       fig, ax = plt.subplots() 
       ax.pie(pie_data, labels=pie_data.index, autopct='%1.1f%%', startangle=90) 
       ax.axis('equal') 
       st.pyplot(fig) 
