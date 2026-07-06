import { useState } from 'react';
import { FileText, Send, Building2, PackageSearch, DollarSign, CalendarClock, ChevronRight, CheckCircle2 } from 'lucide-react';

const mockPOs = [
  {
    id: 'PO-2026-089',
    supplier: 'GlobalTech Electronics Ltd.',
    item: 'Microcontroller Unit (MCU-32)',
    quantity: 2500,
    cost: 4250.00,
    date: 'Drafted 2 hrs ago',
    status: 'pending',
    reason: 'Critical stock risk predicted in 2 days based on velocity spike.'
  },
  {
    id: 'PO-2026-090',
    supplier: 'PowerCore Solutions',
    item: 'Lithium-Ion Battery Pack',
    quantity: 500,
    cost: 12500.00,
    date: 'Drafted 5 hrs ago',
    status: 'pending',
    reason: 'Routine restock to maintain minimum threshold levels.'
  },
  {
    id: 'PO-2026-091',
    supplier: 'DisplayWorks Inc.',
    item: 'OLED Display Module',
    quantity: 1000,
    cost: 8500.00,
    date: 'Drafted 1 day ago',
    status: 'pending',
    reason: 'Fulfilling upcoming bulk order requirements.'
  }
];

export default function PurchaseOrders() {
  const [selectedPO, setSelectedPO] = useState(mockPOs[0]);
  const [sentPOs, setSentPOs] = useState([]);
  const [isSending, setIsSending] = useState(false);

  const handleSend = () => {
    setIsSending(true);
    setTimeout(() => {
      setSentPOs([...sentPOs, selectedPO.id]);
      setIsSending(false);
    }, 1500);
  };

  const isSent = sentPOs.includes(selectedPO.id);

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full h-full flex flex-col">
      <div className="mb-8">
        <h1 className="text-2xl font-bold tracking-tight text-white">Purchase Orders</h1>
        <p className="text-sm text-gray-400 mt-1">Review and approve AI-drafted restock orders.</p>
      </div>

      <div className="flex-1 flex flex-col lg:flex-row gap-6 min-h-[600px]">
        {/* Left Panel: PO List */}
        <div className="w-full lg:w-1/3 flex flex-col gap-3">
          {mockPOs.map((po) => {
            const isSelected = selectedPO.id === po.id;
            const hasBeenSent = sentPOs.includes(po.id);
            return (
              <button
                key={po.id}
                onClick={() => setSelectedPO(po)}
                className={`text-left p-4 rounded-xl border transition-all duration-200 ${
                  isSelected 
                    ? 'bg-indigo-500/10 border-indigo-500/50 shadow-[0_0_15px_rgba(99,102,241,0.1)]' 
                    : 'bg-[var(--card)] border-[var(--border)] hover:border-gray-600'
                }`}
              >
                <div className="flex justify-between items-start mb-2">
                  <span className={`text-xs font-semibold px-2 py-1 rounded-md ${
                    hasBeenSent ? 'bg-emerald-500/20 text-emerald-400' : 'bg-gray-800 text-gray-300'
                  }`}>
                    {hasBeenSent ? 'Sent' : 'Draft'}
                  </span>
                  <span className="text-xs text-gray-500 flex items-center gap-1">
                    <CalendarClock className="w-3 h-3" /> {po.date}
                  </span>
                </div>
                <h3 className={`font-medium mb-1 ${isSelected ? 'text-indigo-400' : 'text-gray-200'}`}>
                  {po.id}
                </h3>
                <p className="text-sm text-white mb-2">{po.item}</p>
                <p className="text-xs text-gray-400 flex items-center justify-between">
                  <span>{po.supplier}</span>
                  <span className="font-medium text-gray-300">${po.cost.toLocaleString()}</span>
                </p>
              </button>
            );
          })}
        </div>

        {/* Right Panel: PO Details */}
        <div className="flex-1 bg-[var(--card)] border border-[var(--border)] rounded-xl shadow-sm overflow-hidden flex flex-col">
          <div className="p-6 border-b border-[var(--border)] flex justify-between items-start bg-[#1c2128]/30">
            <div>
              <h2 className="text-xl font-bold text-white flex items-center gap-2">
                <FileText className="text-indigo-400" />
                Order Details: {selectedPO.id}
              </h2>
              <span className={`inline-flex items-center gap-1 mt-2 text-sm font-medium ${
                isSent ? 'text-emerald-400' : 'text-yellow-400'
              }`}>
                {isSent ? <CheckCircle2 className="w-4 h-4" /> : <div className="w-2 h-2 rounded-full bg-yellow-400 animate-pulse" />}
                {isSent ? 'Approved & Sent to Supplier' : 'Pending Review'}
              </span>
            </div>
            {!isSent && (
              <button 
                onClick={handleSend}
                disabled={isSending}
                className="flex items-center gap-2 px-5 py-2.5 bg-indigo-500 hover:bg-indigo-600 disabled:bg-indigo-500/50 text-white rounded-lg font-medium transition-colors shadow-lg shadow-indigo-500/25"
              >
                {isSending ? (
                  <>
                    <div className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    Sending...
                  </>
                ) : (
                  <>
                    <Send className="w-4 h-4" />
                    Approve & Send
                  </>
                )}
              </button>
            )}
          </div>

          <div className="p-6 flex-1 space-y-8 overflow-y-auto">
            {/* AI Reasoning */}
            <div className="bg-indigo-500/10 border border-indigo-500/20 rounded-lg p-4">
              <h4 className="text-xs font-semibold uppercase tracking-wider text-indigo-400 mb-2">AI Restock Justification</h4>
              <p className="text-sm text-indigo-100/80 leading-relaxed">{selectedPO.reason}</p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
              {/* Supplier Info */}
              <div>
                <h4 className="text-sm font-medium text-gray-400 mb-4 flex items-center gap-2">
                  <Building2 className="w-4 h-4" /> Supplier Information
                </h4>
                <div className="bg-[#0d1117] rounded-lg p-4 border border-[var(--border)]">
                  <p className="font-semibold text-white mb-1">{selectedPO.supplier}</p>
                  <p className="text-sm text-gray-500 mb-4">Vendor ID: VEND-9021</p>
                  <p className="text-sm text-gray-400 flex items-center gap-2">
                    <span className="text-emerald-400">●</span> 98% Delivery Reliability
                  </p>
                </div>
              </div>

              {/* Order Summary */}
              <div>
                <h4 className="text-sm font-medium text-gray-400 mb-4 flex items-center gap-2">
                  <DollarSign className="w-4 h-4" /> Order Summary
                </h4>
                <div className="bg-[#0d1117] rounded-lg p-4 border border-[var(--border)] space-y-3">
                  <div className="flex justify-between text-sm">
                    <span className="text-gray-400">Subtotal</span>
                    <span className="text-white">${(selectedPO.cost * 0.9).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                  </div>
                  <div className="flex justify-between text-sm">
                    <span className="text-gray-400">Estimated Tax/Shipping</span>
                    <span className="text-white">${(selectedPO.cost * 0.1).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                  </div>
                  <div className="pt-3 border-t border-[var(--border)] flex justify-between">
                    <span className="font-medium text-white">Total Estimated Cost</span>
                    <span className="font-bold text-indigo-400">${selectedPO.cost.toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                  </div>
                </div>
              </div>
            </div>

            {/* Item Breakdown */}
            <div>
              <h4 className="text-sm font-medium text-gray-400 mb-4 flex items-center gap-2">
                <PackageSearch className="w-4 h-4" /> Item Breakdown
              </h4>
              <div className="bg-[#0d1117] border border-[var(--border)] rounded-lg overflow-hidden">
                <table className="w-full text-left text-sm">
                  <thead className="bg-[#161b22] border-b border-[var(--border)]">
                    <tr>
                      <th className="px-4 py-3 font-medium text-gray-400">Item</th>
                      <th className="px-4 py-3 font-medium text-gray-400 text-right">Quantity</th>
                      <th className="px-4 py-3 font-medium text-gray-400 text-right">Unit Price</th>
                      <th className="px-4 py-3 font-medium text-gray-400 text-right">Total</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-[var(--border)]">
                    <tr>
                      <td className="px-4 py-3 text-white">{selectedPO.item}</td>
                      <td className="px-4 py-3 text-white text-right">{selectedPO.quantity.toLocaleString()}</td>
                      <td className="px-4 py-3 text-gray-400 text-right">${(selectedPO.cost / selectedPO.quantity).toFixed(2)}</td>
                      <td className="px-4 py-3 font-medium text-white text-right">${selectedPO.cost.toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  );
}
