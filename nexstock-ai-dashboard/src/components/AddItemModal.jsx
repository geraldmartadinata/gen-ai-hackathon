import { useState } from 'react';
import { X, CheckCircle2 } from 'lucide-react';

export default function AddItemModal({ isOpen, onClose, onSave }) {
  const [isSaving, setIsSaving] = useState(false);
  const [isSuccess, setIsSuccess] = useState(false);

  if (!isOpen) return null;

  const handleSave = (e) => {
    e.preventDefault();
    setIsSaving(true);
    // Simulate save delay
    setTimeout(() => {
      setIsSaving(false);
      setIsSuccess(true);
      setTimeout(() => {
        setIsSuccess(false);
        onSave(); // Close the modal
      }, 1500);
    }, 1000);
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
      {/* Backdrop */}
      <div 
        className="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
        onClick={!isSaving && !isSuccess ? onClose : undefined}
      ></div>

      {/* Modal Container */}
      <div className="relative w-full max-w-md bg-[#0d1117] border border-[var(--border)] rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        
        {isSuccess ? (
          <div className="flex flex-col items-center justify-center py-16 text-center">
            <div className="w-16 h-16 bg-emerald-500/20 rounded-full flex items-center justify-center mb-6 animate-in zoom-in">
              <CheckCircle2 className="w-10 h-10 text-emerald-400" />
            </div>
            <h3 className="text-xl font-semibold text-white mb-2">Item Added Successfully!</h3>
            <p className="text-gray-400">The inventory database has been updated.</p>
          </div>
        ) : (
          <>
            {/* Header */}
            <div className="px-6 py-4 border-b border-[var(--border)] flex justify-between items-center bg-[#161b22]">
              <h2 className="text-lg font-semibold text-white">Add New Item</h2>
              <button 
                onClick={onClose}
                className="text-gray-400 hover:text-white transition-colors"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            {/* Form */}
            <form onSubmit={handleSave} className="p-6 space-y-4">
              <div>
                <label className="block text-sm font-medium text-gray-300 mb-1">Item Name</label>
                <input 
                  type="text" 
                  required
                  placeholder="e.g. Raspberry Pi 5"
                  className="w-full bg-[#161b22] border border-[#30363d] rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                />
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-300 mb-1">Category</label>
                <select className="w-full bg-[#161b22] border border-[#30363d] rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                  <option>Processors</option>
                  <option>Displays</option>
                  <option>Power</option>
                  <option>Hardware</option>
                  <option>Connectivity</option>
                  <option>Consumables</option>
                </select>
              </div>

              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-300 mb-1">Initial Stock</label>
                  <input 
                    type="number" 
                    required
                    min="0"
                    placeholder="0"
                    className="w-full bg-[#161b22] border border-[#30363d] rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-300 mb-1">Unit Price ($)</label>
                  <input 
                    type="number" 
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                    className="w-full bg-[#161b22] border border-[#30363d] rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                  />
                </div>
              </div>

              <div className="pt-4 flex gap-3 justify-end">
                <button 
                  type="button"
                  onClick={onClose}
                  className="px-4 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 transition-colors"
                >
                  Cancel
                </button>
                <button 
                  type="submit"
                  disabled={isSaving}
                  className="px-4 py-2 rounded-lg text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 disabled:bg-indigo-500/50 transition-colors shadow-sm flex items-center gap-2"
                >
                  {isSaving ? (
                    <>
                      <div className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                      Saving...
                    </>
                  ) : (
                    'Save Item'
                  )}
                </button>
              </div>
            </form>
          </>
        )}
      </div>
    </div>
  );
}
