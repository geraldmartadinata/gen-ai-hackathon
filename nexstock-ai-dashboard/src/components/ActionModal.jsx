import { useState, useEffect } from 'react';
import { X, Sparkles, FileText, CheckCircle2 } from 'lucide-react';

export default function ActionModal({ isOpen, onClose }) {
  const [isLoading, setIsLoading] = useState(true);
  const [isSuccess, setIsSuccess] = useState(false);

  useEffect(() => {
    if (isOpen) {
      setIsLoading(true);
      setIsSuccess(false);
      // Simulate Gemini API delay
      const timer = setTimeout(() => {
        setIsLoading(false);
      }, 2500);
      return () => clearTimeout(timer);
    }
  }, [isOpen]);

  if (!isOpen) return null;

  const handleConfirm = () => {
    setIsSuccess(true);
    setTimeout(() => {
      onClose();
    }, 1500);
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
      {/* Backdrop */}
      <div 
        className="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
        onClick={!isLoading && !isSuccess ? onClose : undefined}
      ></div>

      {/* Modal Container */}
      <div className="relative w-full max-w-lg bg-[#0d1117] border border-[var(--border)] rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        
        {/* Glow Effect */}
        <div className="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-50"></div>

        {/* Content */}
        <div className="p-6">
          {!isLoading && !isSuccess && (
            <button 
              onClick={onClose}
              className="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors"
            >
              <X className="w-5 h-5" />
            </button>
          )}

          {isLoading ? (
            <div className="flex flex-col items-center justify-center py-12 text-center">
              <div className="relative w-16 h-16 mb-6">
                <div className="absolute inset-0 border-4 border-indigo-500/30 rounded-full"></div>
                <div className="absolute inset-0 border-4 border-indigo-500 rounded-full border-t-transparent animate-spin"></div>
                <Sparkles className="absolute inset-0 m-auto w-6 h-6 text-indigo-400 animate-pulse" />
              </div>
              <h3 className="text-xl font-semibold text-white mb-2">Analyzing Optimal Supplier</h3>
              <p className="text-indigo-300 flex items-center gap-2">
                <Sparkles className="w-4 h-4" />
                Gemini is drafting PO...
              </p>
            </div>
          ) : isSuccess ? (
            <div className="flex flex-col items-center justify-center py-12 text-center animate-in fade-in slide-in-from-bottom-4">
              <div className="w-16 h-16 bg-emerald-500/20 rounded-full flex items-center justify-center mb-6">
                <CheckCircle2 className="w-10 h-10 text-emerald-400" />
              </div>
              <h3 className="text-xl font-semibold text-white mb-2">Purchase Order Sent!</h3>
              <p className="text-gray-400">The supplier has been notified.</p>
            </div>
          ) : (
            <div className="animate-in fade-in slide-in-from-bottom-4">
              <div className="flex items-center gap-3 mb-6">
                <div className="w-10 h-10 rounded-lg bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30">
                  <FileText className="w-5 h-5 text-indigo-400" />
                </div>
                <div>
                  <h3 className="text-xl font-semibold text-white">Drafted Purchase Order</h3>
                  <p className="text-sm text-gray-400">Review AI-generated details</p>
                </div>
              </div>

              <div className="space-y-4 mb-8">
                <div className="bg-[#161b22] rounded-lg p-4 border border-[var(--border)]">
                  <div className="grid grid-cols-2 gap-4">
                    <div>
                      <span className="block text-xs font-medium text-gray-500 mb-1">Item</span>
                      <span className="block text-sm text-white font-medium">Microcontroller Unit (MCU-32)</span>
                    </div>
                    <div>
                      <span className="block text-xs font-medium text-gray-500 mb-1">Supplier</span>
                      <span className="block text-sm text-white font-medium">GlobalTech Electronics Ltd.</span>
                    </div>
                    <div>
                      <span className="block text-xs font-medium text-gray-500 mb-1">Quantity</span>
                      <span className="block text-sm text-white font-medium">2,500 units</span>
                    </div>
                    <div>
                      <span className="block text-xs font-medium text-gray-500 mb-1">Estimated Cost</span>
                      <span className="block text-sm text-white font-medium">$4,250.00</span>
                    </div>
                  </div>
                </div>
                
                <div className="bg-indigo-500/10 border border-indigo-500/20 rounded-lg p-3 flex gap-3">
                  <Sparkles className="w-5 h-5 text-indigo-400 shrink-0 mt-0.5" />
                  <p className="text-sm text-indigo-200">
                    Gemini selected <strong>GlobalTech</strong> based on historical delivery reliability (98%) and lowest current bulk pricing.
                  </p>
                </div>
              </div>

              <div className="flex gap-3 justify-end">
                <button 
                  onClick={onClose}
                  className="px-4 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 transition-colors"
                >
                  Cancel
                </button>
                <button 
                  onClick={handleConfirm}
                  className="px-4 py-2 rounded-lg text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 transition-colors shadow-lg shadow-indigo-500/25 flex items-center gap-2"
                >
                  Confirm & Send PO
                </button>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
