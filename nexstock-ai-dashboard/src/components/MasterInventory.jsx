import { Search, Filter, Plus, CheckCircle2, AlertCircle, Clock } from 'lucide-react';
import { useState } from 'react';
import AddItemModal from './AddItemModal';

const mockInventory = [
  { id: 'ITM-001', name: 'Microcontroller Unit (MCU-32)', category: 'Processors', stock: 12, status: 'Critical', lastRestocked: '2026-06-15' },
  { id: 'ITM-002', name: 'Lithium-Ion Battery Pack', category: 'Power', stock: 45, status: 'Low', lastRestocked: '2026-06-20' },
  { id: 'ITM-003', name: 'OLED Display Module', category: 'Displays', stock: 18, status: 'Critical', lastRestocked: '2026-06-10' },
  { id: 'ITM-004', name: 'USB-C Connectors', category: 'Hardware', stock: 240, status: 'Healthy', lastRestocked: '2026-07-01' },
  { id: 'ITM-005', name: 'Power Management IC', category: 'Processors', stock: 32, status: 'Low', lastRestocked: '2026-06-28' },
  { id: 'ITM-006', name: 'Bluetooth 5.0 Module', category: 'Connectivity', stock: 150, status: 'Healthy', lastRestocked: '2026-06-25' },
  { id: 'ITM-007', name: 'PCB Prototype Boards', category: 'Hardware', stock: 500, status: 'Healthy', lastRestocked: '2026-05-15' },
  { id: 'ITM-008', name: 'Capacitor Kit (100nF)', category: 'Components', stock: 1200, status: 'Healthy', lastRestocked: '2026-06-01' },
  { id: 'ITM-009', name: 'Thermal Paste (10g)', category: 'Consumables', stock: 5, status: 'Critical', lastRestocked: '2026-04-10' },
  { id: 'ITM-010', name: 'Cooling Fan 40mm', category: 'Hardware', stock: 85, status: 'Healthy', lastRestocked: '2026-06-29' },
];

const StatusBadge = ({ status }) => {
  if (status === 'Critical') {
    return (
      <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-500/10 text-red-400 text-xs font-medium border border-red-500/20">
        <AlertCircle className="w-3.5 h-3.5" /> Critical
      </span>
    );
  }
  if (status === 'Low') {
    return (
      <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-yellow-500/10 text-yellow-400 text-xs font-medium border border-yellow-500/20">
        <Clock className="w-3.5 h-3.5" /> Low Stock
      </span>
    );
  }
  return (
    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-medium border border-emerald-500/20">
      <CheckCircle2 className="w-3.5 h-3.5" /> Healthy
    </span>
  );
};

export default function MasterInventory() {
  const [searchTerm, setSearchTerm] = useState('');
  const [isFilterOpen, setIsFilterOpen] = useState(false);
  const [filters, setFilters] = useState({ Critical: false, Low: false, Healthy: false });
  const [isAddModalOpen, setIsAddModalOpen] = useState(false);

  const toggleFilter = (status) => {
    setFilters(prev => ({ ...prev, [status]: !prev[status] }));
  };

  const filteredInventory = mockInventory.filter(item => {
    const matchesSearch = item.name.toLowerCase().includes(searchTerm.toLowerCase()) || 
                          item.id.toLowerCase().includes(searchTerm.toLowerCase());
    
    const isFilterActive = filters.Critical || filters.Low || filters.Healthy;
    const matchesFilter = !isFilterActive || filters[item.status] || (item.status === 'Low Stock' && filters.Low);

    return matchesSearch && matchesFilter;
  });

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-white">Master Inventory</h1>
          <p className="text-sm text-gray-400 mt-1">Manage and track all hardware components across warehouses.</p>
        </div>
        <button 
          onClick={() => setIsAddModalOpen(true)}
          className="flex items-center gap-2 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm"
        >
          <Plus className="w-4 h-4" />
          Add Item
        </button>
      </div>

      <div className="bg-[var(--card)] border border-[var(--border)] rounded-xl shadow-sm overflow-hidden flex flex-col relative">
        {/* Toolbar */}
        <div className="p-4 border-b border-[var(--border)] flex flex-col sm:flex-row gap-4 justify-between items-center bg-[#1c2128]">
          <div className="relative w-full sm:w-96">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" />
            <input 
              type="text" 
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              placeholder="Search inventory (e.g., 'Microcontroller')" 
              className="w-full bg-[#0d1117] border border-[#30363d] rounded-lg pl-10 pr-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
            />
          </div>
          
          <div className="relative w-full sm:w-auto">
            <button 
              onClick={() => setIsFilterOpen(!isFilterOpen)}
              className="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-300 bg-[#0d1117] border border-[var(--border)] rounded-lg hover:bg-gray-800 transition-colors w-full sm:w-auto justify-center"
            >
              <Filter className="w-4 h-4" />
              Filters {(filters.Critical || filters.Low || filters.Healthy) && <span className="w-2 h-2 rounded-full bg-indigo-500 ml-1"></span>}
            </button>

            {/* Filter Popover */}
            {isFilterOpen && (
              <div className="absolute right-0 mt-2 w-48 bg-[#161b22] border border-[#30363d] rounded-lg shadow-xl z-10 p-3 animate-in fade-in slide-in-from-top-2">
                <h4 className="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Status</h4>
                <label className="flex items-center gap-2 py-1.5 cursor-pointer hover:bg-gray-800/50 rounded px-2 -mx-2 transition-colors">
                  <input type="checkbox" checked={filters.Critical} onChange={() => toggleFilter('Critical')} className="rounded border-gray-600 bg-gray-700 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-gray-900" />
                  <span className="text-sm text-gray-300">Critical</span>
                </label>
                <label className="flex items-center gap-2 py-1.5 cursor-pointer hover:bg-gray-800/50 rounded px-2 -mx-2 transition-colors">
                  <input type="checkbox" checked={filters.Low} onChange={() => toggleFilter('Low')} className="rounded border-gray-600 bg-gray-700 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-gray-900" />
                  <span className="text-sm text-gray-300">Low Stock</span>
                </label>
                <label className="flex items-center gap-2 py-1.5 cursor-pointer hover:bg-gray-800/50 rounded px-2 -mx-2 transition-colors">
                  <input type="checkbox" checked={filters.Healthy} onChange={() => toggleFilter('Healthy')} className="rounded border-gray-600 bg-gray-700 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-gray-900" />
                  <span className="text-sm text-gray-300">Healthy</span>
                </label>
              </div>
            )}
          </div>
        </div>

        {/* Table */}
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse min-w-[800px]">
            <thead>
              <tr className="bg-[#161b22] border-b border-[var(--border)]">
                <th className="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Item ID</th>
                <th className="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Item Name</th>
                <th className="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Category</th>
                <th className="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Stock Level</th>
                <th className="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                <th className="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Last Restocked</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-[var(--border)] bg-[#0d1117]">
              {filteredInventory.length > 0 ? (
                filteredInventory.map((item) => (
                  <tr key={item.id} className="hover:bg-gray-800/40 transition-colors group">
                    <td className="py-4 px-6 text-sm font-medium text-gray-400">{item.id}</td>
                    <td className="py-4 px-6 text-sm font-medium text-white group-hover:text-indigo-400 transition-colors cursor-pointer">{item.name}</td>
                    <td className="py-4 px-6 text-sm text-gray-400">{item.category}</td>
                    <td className="py-4 px-6 text-sm text-white font-medium text-right">{item.stock.toLocaleString()}</td>
                    <td className="py-4 px-6">
                      <StatusBadge status={item.status} />
                    </td>
                    <td className="py-4 px-6 text-sm text-gray-400">{item.lastRestocked}</td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="6" className="py-8 text-center text-gray-500">
                    No items found matching your search or filters.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
        
        {/* Pagination Footer */}
        <div className="p-4 border-t border-[var(--border)] flex justify-between items-center bg-[#161b22]">
          <span className="text-sm text-gray-500">Showing <strong className="text-white">{filteredInventory.length}</strong> items</span>
          <div className="flex items-center gap-2">
            <button className="px-3 py-1 border border-[var(--border)] rounded text-sm text-gray-400 hover:text-white hover:bg-gray-800 disabled:opacity-50" disabled>Prev</button>
            <button className="px-3 py-1 border border-indigo-500 bg-indigo-500/10 rounded text-sm text-indigo-400 font-medium">1</button>
            <button className="px-3 py-1 border border-[var(--border)] rounded text-sm text-gray-400 hover:text-white hover:bg-gray-800 disabled:opacity-50" disabled>Next</button>
          </div>
        </div>
      </div>

      <AddItemModal 
        isOpen={isAddModalOpen} 
        onClose={() => setIsAddModalOpen(false)}
        onSave={() => setIsAddModalOpen(false)}
      />
    </div>
  );
}
