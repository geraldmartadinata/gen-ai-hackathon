import { AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer, Legend } from 'recharts';
import { Filter, Calendar, Download } from 'lucide-react';
import { useState } from 'react';

// Extended mock data for a 30-day view
const generateMockData = (days) => {
  const data = [];
  let currentStock = 12000;
  let predictedDemandBase = 2000;
  
  const today = new Date();
  
  for (let i = 0; i < days; i++) {
    const date = new Date(today);
    date.setDate(today.getDate() + i);
    
    // Add some noise
    const demandSpike = (i % 7 === 5 || i % 7 === 6) ? 1500 : 0; // Weekend spikes
    const dailyDemand = predictedDemandBase + demandSpike + (Math.random() * 800 - 400);
    
    currentStock = Math.max(0, currentStock - dailyDemand * 0.8 + (i % 14 === 0 && i !== 0 ? 10000 : 0)); // Simulated restock every 14 days
    
    data.push({
      date: date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }),
      'Current Stock': Math.round(currentStock),
      'Predicted Demand': Math.round(dailyDemand)
    });
  }
  return data;
};

const data7Days = generateMockData(7);
const data14Days = generateMockData(14);
const data30Days = generateMockData(30);

export default function DemandForecasting() {
  const [window, setWindow] = useState('14');
  const [category, setCategory] = useState('All');

  const getChartData = () => {
    switch(window) {
      case '7': return data7Days;
      case '30': return data30Days;
      default: return data14Days;
    }
  };

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex flex-col h-full">
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-white">Demand Forecasting</h1>
          <p className="text-sm text-gray-400 mt-1">AI-powered predictive analytics for inventory optimization.</p>
        </div>
        
        <div className="flex items-center gap-3">
          <button className="flex items-center gap-2 px-4 py-2 bg-[#161b22] border border-[var(--border)] rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
            <Download className="w-4 h-4" />
            Export Data
          </button>
        </div>
      </div>

      <div className="bg-[var(--card)] border border-[var(--border)] rounded-xl shadow-sm flex flex-col flex-1 min-h-[500px]">
        {/* Control Panel */}
        <div className="p-4 border-b border-[var(--border)] flex flex-wrap gap-4 justify-between items-center bg-[#1c2128]/50">
          <div className="flex items-center gap-4">
            <div className="flex items-center gap-2">
              <Filter className="w-4 h-4 text-gray-400" />
              <select 
                value={category}
                onChange={(e) => setCategory(e.target.value)}
                className="bg-[#0d1117] border border-[#30363d] rounded-lg px-3 py-1.5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
              >
                <option value="All">All Categories</option>
                <option value="Electronics">Electronics</option>
                <option value="Hardware">Hardware</option>
              </select>
            </div>
            
            <div className="flex items-center gap-2">
              <Calendar className="w-4 h-4 text-gray-400" />
              <select 
                value={window}
                onChange={(e) => setWindow(e.target.value)}
                className="bg-[#0d1117] border border-[#30363d] rounded-lg px-3 py-1.5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
              >
                <option value="7">Next 7 Days</option>
                <option value="14">Next 14 Days</option>
                <option value="30">Next 30 Days</option>
              </select>
            </div>
          </div>
          
          <div className="flex items-center gap-4 text-sm">
            <div className="flex items-center gap-2">
              <span className="w-3 h-3 rounded-full bg-emerald-500/20 border border-emerald-500"></span>
              <span className="text-gray-400">Stock</span>
            </div>
            <div className="flex items-center gap-2">
              <span className="w-3 h-3 rounded-full bg-indigo-500/20 border border-indigo-500"></span>
              <span className="text-gray-400">Demand</span>
            </div>
          </div>
        </div>

        {/* Chart Area */}
        <div className="p-6 flex-1 w-full h-full">
          <ResponsiveContainer width="100%" height="100%">
            <AreaChart
              data={getChartData()}
              margin={{ top: 10, right: 30, left: 0, bottom: 0 }}
            >
              <defs>
                <linearGradient id="colorStock" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="5%" stopColor="#10b981" stopOpacity={0.3}/>
                  <stop offset="95%" stopColor="#10b981" stopOpacity={0}/>
                </linearGradient>
                <linearGradient id="colorDemand" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="5%" stopColor="#6366f1" stopOpacity={0.3}/>
                  <stop offset="95%" stopColor="#6366f1" stopOpacity={0}/>
                </linearGradient>
              </defs>
              <CartesianGrid strokeDasharray="3 3" stroke="#30363d" vertical={false} />
              <XAxis dataKey="date" stroke="#8b949e" tick={{fill: '#8b949e', fontSize: 12}} tickLine={false} axisLine={false} dy={10} />
              <YAxis stroke="#8b949e" tick={{fill: '#8b949e', fontSize: 12}} tickLine={false} axisLine={false} dx={-10} />
              <Tooltip 
                contentStyle={{ backgroundColor: '#161b22', borderColor: '#30363d', borderRadius: '8px', color: '#fff', boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)' }}
                itemStyle={{ color: '#fff', fontWeight: 500 }}
              />
              <Area type="monotone" dataKey="Current Stock" stroke="#10b981" strokeWidth={3} fillOpacity={1} fill="url(#colorStock)" activeDot={{ r: 6, strokeWidth: 0 }} />
              <Area type="monotone" dataKey="Predicted Demand" stroke="#6366f1" strokeWidth={3} fillOpacity={1} fill="url(#colorDemand)" activeDot={{ r: 6, strokeWidth: 0 }} />
            </AreaChart>
          </ResponsiveContainer>
        </div>
      </div>
    </div>
  );
}
