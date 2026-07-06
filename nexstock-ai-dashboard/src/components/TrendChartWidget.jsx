import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';

const data = [
  { day: 'Mon', 'Current Stock': 4000, 'Forecasted Demand': 2400 },
  { day: 'Tue', 'Current Stock': 3000, 'Forecasted Demand': 1398 },
  { day: 'Wed', 'Current Stock': 2000, 'Forecasted Demand': 9800 },
  { day: 'Thu', 'Current Stock': 2780, 'Forecasted Demand': 3908 },
  { day: 'Fri', 'Current Stock': 1890, 'Forecasted Demand': 4800 },
  { day: 'Sat', 'Current Stock': 2390, 'Forecasted Demand': 3800 },
  { day: 'Sun', 'Current Stock': 3490, 'Forecasted Demand': 4300 },
];

export default function TrendChartWidget() {
  return (
    <div className="bg-[var(--card)] border border-[var(--border)] rounded-xl p-6 h-full flex flex-col shadow-sm">
      <div className="mb-4">
        <h3 className="text-lg font-semibold text-white">Demand Forecasting (Next 7 Days)</h3>
        <p className="text-sm text-gray-400">Current Stock Levels vs Forecasted Demand</p>
      </div>
      
      <div className="flex-1 w-full min-h-[300px]">
        <ResponsiveContainer width="100%" height="100%">
          <LineChart
            data={data}
            margin={{ top: 5, right: 20, left: 0, bottom: 5 }}
          >
            <CartesianGrid strokeDasharray="3 3" stroke="#30363d" vertical={false} />
            <XAxis dataKey="day" stroke="#8b949e" tick={{fill: '#8b949e'}} tickLine={false} axisLine={false} />
            <YAxis stroke="#8b949e" tick={{fill: '#8b949e'}} tickLine={false} axisLine={false} />
            <Tooltip 
              contentStyle={{ backgroundColor: '#161b22', borderColor: '#30363d', borderRadius: '8px', color: '#fff' }}
              itemStyle={{ color: '#fff' }}
            />
            <Legend wrapperStyle={{ paddingTop: '20px' }} />
            <Line type="monotone" dataKey="Current Stock" stroke="#10b981" strokeWidth={3} dot={{ r: 4, fill: '#10b981', strokeWidth: 0 }} activeDot={{ r: 6 }} />
            <Line type="monotone" dataKey="Forecasted Demand" stroke="#6366f1" strokeWidth={3} dot={{ r: 4, fill: '#6366f1', strokeWidth: 0 }} activeDot={{ r: 6 }} />
          </LineChart>
        </ResponsiveContainer>
      </div>
    </div>
  );
}
