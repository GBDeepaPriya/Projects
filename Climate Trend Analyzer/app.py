import streamlit as st
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns

# Title
st.title("🌡️ Global Climate Dashboard")

# Upload CSV
uploaded_file = st.file_uploader("Upload your GlobalTemperatures.csv file", type=['csv'])
if uploaded_file:
    df = pd.read_csv(uploaded_file)
    
    # Preprocessing
    df['Date'] = pd.to_datetime(df['Date'])
    df = df.sort_values(by='Date')
    df['Temperature'] = df['Temperature'].fillna(df['Temperature'].mean())
    df['Rolling_Avg'] = df['Temperature'].rolling(window=12).mean()
    df['Hour'] = df['Date'].dt.hour
    df['Minute'] = df['Date'].dt.minute

    # Sidebar Options
    st.sidebar.subheader("Choose Visualizations:")
    show_hist = st.sidebar.checkbox("Show Temperature Histogram")
    show_line = st.sidebar.checkbox("Show Time Series Plot")
    show_trend = st.sidebar.checkbox("Show Rolling Average Trend")
    show_heatmap = st.sidebar.checkbox("Show Monthly Heatmap")
    show_scatter = st.sidebar.checkbox("Show CO₂ vs Temperature (if available)")

    # Summary
    st.subheader("📊 Summary Statistics")
    st.write(df.describe())

    if show_hist:
        st.subheader("🌡️ Temperature Distribution")
        fig, ax = plt.subplots()
        df['Temperature'].plot(kind='hist', bins=30, ax=ax)
        st.pyplot(fig)

    if show_line:
        st.subheader("📈 Global Temperature Over Time")
        fig, ax = plt.subplots()
        ax.plot(df['Date'], df['Temperature'], label='Temperature')
        ax.set_xlabel('Year')
        ax.set_ylabel('°C')
        ax.set_title("Global Temperature Over Time")
        ax.legend()
        st.pyplot(fig)

    if show_trend:
        st.subheader("📉 Rolling Average Trend (12-month window)")
        fig, ax = plt.subplots()
        ax.plot(df['Date'], df['Temperature'], alpha=0.4, label='Monthly Temp')
        ax.plot(df['Date'], df['Rolling_Avg'], color='red', label='Rolling Avg')
        ax.set_title("Smoothed Temperature Trend")
        ax.legend()
        st.pyplot(fig)

    if show_heatmap:
        st.subheader("🌍 Monthly Temperature Heatmap Over Years")
        pivot = df.pivot_table(index='Minute', columns='Hour', values='Temperature')
        fig, ax = plt.subplots(figsize=(16, 8))
        sns.heatmap(pivot, cmap='coolwarm', linewidths=0.1, ax=ax)
        ax.set_title('Monthly Temperature Heatmap')
        st.pyplot(fig)

    if show_scatter and 'CO2' in df.columns:
        st.subheader("🟠 CO₂ vs. Temperature")
        fig, ax = plt.subplots()
        ax.scatter(df['CO2'], df['Temperature'])
        ax.set_xlabel("CO₂ (ppm)")
        ax.set_ylabel("Temperature (°C)")
        ax.set_title("CO₂ Levels vs Temperature")
        st.pyplot(fig)
