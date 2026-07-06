import { AlertTriangle, Clock, ShieldCheck, ShoppingCart } from 'lucide-react';

const mockData = [
  { id: 1, name: 'Microcontroller Unit (MCU-32)', stock: 12, predictedDate: '2 Days', risk: 'high' },
  { id: 2, name: 'Lithium-Ion Battery Pack', stock: 45, predictedDate: '5 Days', risk: 'medium' },
  { id: 3, name: 'OLED Display Module', stock: 18, predictedDate: '3 Days', risk: 'high' },
  { id: 4, name: 'USB-C Connectors', stock: 240, predictedDate: '12 Days', risk: 'low' },
  { id: 5, name: 'Power Management IC', stock: 32, predictedDate: '4 Days', risk: 'medium' },
];

const RiskBadge = ({ risk }) => {
  if (risk === 'high') {
    return (
      <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-500/10 text-red-400 text-xs font-medium border border-red-500/20">
        <AlertTriangle className="w-3.5 h-3.5" /> High Risk
      </span>
    );
  }
  if (risk === 'medium') {
    return (
      <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-yellow-500/10 text-yellow-400 text-xs font-medium border border-yellow-500/20">
        <Clock className="w-3.5 h-3.5" /> Medium
      </span>
    );
  }
  return (
    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-medium border border-emerald-500/20">
      <ShieldCheck className="w-3.5 h-3.5" /> Low
    </span>
  );
};

export default function StockRiskTable({ onOpenModal }) {
  return (
    <div className="bg-[var(--card)] border border-[var(--border)] rounded-xl shadow-sm overflow-hidden">
      <div className="p-6 border-b border-[var(--border)]">
        <h3 className="text-lg font-semibold text-white">Critical Stock Risk Analysis</h3>
        <p className="text-sm text-gray-400">AI-predicted run-out dates based on current velocity.</p>
      </div>
      
      <div className="overflow-x-auto">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-900/50 border-b border-[var(--border)]">
              <th className="py-4 px-6 text-sm font-semibold text-gray-300">Item Name</th>
              <th className="py-4 px-6 text-sm font-semibold text-gray-300">Current Stock</th>
              <th className="py-4 px-6 text-sm font-semibold text-gray-300">Predicted Run-out Date</th>
              <th className="py-4 px-6 text-sm font-semibold text-gray-300">Risk Score</th>
              <th className="py-4 px-6 text-sm font-semibold text-gray-300 text-right">Action</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-[var(--border)]">
            {mockData.map((item) => (
              <tr key={item.id} className="hover:bg-gray-800/30 transition-colors">
                <td className="py-4 px-6 text-sm font-medium text-white">{item.name}</td>
                <td className="py-4 px-6 text-sm text-gray-300">{item.stock} units</td>
                <td className="py-4 px-6 text-sm text-gray-300">{item.predictedDate}</td>
                <td className="py-4 px-6">
                  <RiskBadge risk={item.risk} />
                </td>
                <td className="py-4 px-6 text-right">
                  <button 
                    onClick={onOpenModal}
                    className="inline-flex items-center justify-center gap-2 px-3 py-1.5 text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-md transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900"
                  >
                    <ShoppingCart className="w-4 h-4" />
                    Quick Restock
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
